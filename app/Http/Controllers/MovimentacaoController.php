<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Interfaces\LivroRepositoryInterface;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;


class MovimentacaoController extends Controller
{

    private MovimentacaoRepositoryInterface $movimentacaoRepository;
    private EstoqueRepositoryInterface $estoqueRepository;
    private LivroRepositoryInterface $livroRepository;
    private FornecedorRepositoryInterface $fornecedorRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        MovimentacaoRepositoryInterface $movimentacaoRepository,
        EstoqueRepositoryInterface $estoqueRepository,
        LivroRepositoryInterface $livroRepository,
        FornecedorRepositoryInterface $fornecedorRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->movimentacaoRepository = $movimentacaoRepository;
        $this->estoqueRepository = $estoqueRepository;
        $this->livroRepository = $livroRepository;
        $this->fornecedorRepository = $fornecedorRepository;
        $this->userRepository = $userRepository;

        $this->authorizeResource(Movimentacao::class, 'movimentacao');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movimentacoes = $this->movimentacaoRepository->allWithLivroAndUser();
        $livros = $this->livroRepository->allWithGenero(); 
        $fornecedores = $this->fornecedorRepository->all();
        $users = $this->userRepository->allWithCargoAndSetor(); 

        $livrosOptions = $livros->map(fn($l) => (object)[
            'id' => $l->id,
            'nome' => $l->titulo
        ]);

        $fornecedoresOptions = $fornecedores->map(fn($f) => (object)[
            'id' => $f->id,
            'nome' => $f->razao_social,
        ]);

        return view(
            'movimentacoes.index',
            compact('movimentacoes', 'livros', 'livrosOptions', 'fornecedores', 'fornecedoresOptions', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'livro_id'            => ['required', 'exists:livros,id'],
            'tipo'                => ['required', Rule::in(['entrada', 'saida'])],
            'quantidade'          => ['required', 'integer', 'min:1'],

            // mantém a lógica original
            'tipo_relacionamento' => ['required', Rule::in(['fornecedor', 'cliente'])],

            // somente fornecedor usa id
            'relacionamento_id'   => [
                Rule::requiredIf($request->tipo_relacionamento === 'fornecedor'),
                'nullable',
                'exists:fornecedores,id'
            ],

            // cliente exige nome e telefone, fornecedor não
            'nome_contato' => [
                $request->tipo_relacionamento === 'cliente' ? 'required' : 'nullable',
                'string',
                'max:150'
            ],

            'telefone_contato' => [
                $request->tipo_relacionamento === 'cliente' ? 'required' : 'nullable',
                'string',
                'max:20'
            ],

            'observacao' => ['nullable', 'string'],
        ]);

        $estoque = $this->estoqueRepository->findOrCreateByLivroId($request->livro_id);

        if ($request->tipo === 'saida' && $estoque->quantidade_disponivel < $request->quantidade) {
            return back()->withInput()->with('error', 'Não é possível registrar saída. Estoque insuficiente!');
        }

        $data = $validated;

        // fornecedor → preenche nome e telefone automaticamente
        if ($request->tipo_relacionamento === 'fornecedor') {
            $fornecedor = $this->fornecedorRepository->find($request->relacionamento_id);

            if ($fornecedor) {
                $data['nome_contato'] = $fornecedor->razao_social;
                $data['telefone_contato'] = $fornecedor->telefone;
            }
        }

        $data['responsavel'] = Auth::user()->name;

        $this->movimentacaoRepository->create($data);

        return redirect()->route('movimentacoes.index')
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimentacao $movimentacao): RedirectResponse
    {

        try {
            
            $movimentacao->reverterEstoque();

            $this->movimentacaoRepository->delete($movimentacao);

            return redirect()
                ->route('movimentacoes.index')
                ->with('success', 'Movimentação excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('movimentacoes.index')
                ->with('error', $e->getMessage());
        }
    }
}