<?php

namespace App\Http\Controllers;

use App\Services\MovimentacaoService;
use App\Models\Movimentacao;
use App\Models\Livro;
use App\Models\Fornecedor;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
// use InvalidArgumentException; // Pode usar \Exception ou ser específico

class MovimentacaoController extends Controller
{
    /**
     * Injeta o Service (o Orquestrador) no Controller,
     * [cite_start]como no exemplo [cite: 391-396].
     */
    public function __construct(protected MovimentacaoService $service)
    {
    }

    public function index(): View
    {
        $movimentacoes = Movimentacao::with('livro')->get();
        $livros = Livro::all();
        $livrosOptions = $livros->map(fn($livro) => (object)[
            'id' => $livro->id,
            'nome' => $livro->titulo
        ]);
        $fornecedores = Fornecedor::all();
        $fornecedoresOptions = $fornecedores->map(fn($f) => (object)[
            'id' => $f->id,
            'nome' => $f->razao_social,
        ]);
        $users = User::all();

        return view('movimentacoes.index', compact('movimentacoes', 'livros', 'livrosOptions', 'fornecedores', 'fornecedoresOptions', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'quantidade' => 'required|integer|min:1',
            'tipo' => 'required|in:entrada,saida',
            'tipo_relacionamento' => 'required|in:fornecedor,cliente',
            'relacionamento_id' => 'nullable|exists:fornecedores,id',
            'nome_contato' => $request->tipo_relacionamento === 'cliente' ? 'required|string|max:150' : 'nullable|string|max:150',
            'telefone_contato' => $request->tipo_relacionamento === 'cliente' ? 'required|string|max:20' : 'nullable|string|max:20',
            'observacao' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->tipo_relacionamento === 'fornecedor' && $request->relacionamento_id) {
            $fornecedor = Fornecedor::find($request->relacionamento_id);
            $data['nome_contato'] = $fornecedor->razao_social;
            $data['telefone_contato'] = $fornecedor->telefone;
        }

        $movimentacao = Movimentacao::create($data);

        try {

            $this->service->processar($movimentacao);

        } catch (\Exception $e) {
            
            $movimentacao->delete(); 
            
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação registrada com sucesso!');
    }

    public function destroy($id)
    {
        $movimentacao = Movimentacao::findOrFail($id);
        
        try {
            
            $this->service->reverter($movimentacao);

            $movimentacao->delete();

            return redirect()->route('movimentacoes.index')->with('success', 'Movimentação excluída com sucesso!');
        
        } catch (\Exception $e) {
            
            return redirect()->route('movimentacoes.index')->with('error', $e->getMessage());
        }
    }
}