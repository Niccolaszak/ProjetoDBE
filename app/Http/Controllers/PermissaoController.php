<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Interfaces\PermissaoRepositoryInterface;
use App\Interfaces\TelaRepositoryInterface;
use App\Interfaces\CargoRepositoryInterface;
use App\Interfaces\SetorRepositoryInterface;


class PermissaoController extends Controller
{
    private PermissaoRepositoryInterface $permissaoRepository;
    private TelaRepositoryInterface $telaRepository;
    private CargoRepositoryInterface $cargoRepository;
    private SetorRepositoryInterface $setorRepository;

    public function __construct(
        PermissaoRepositoryInterface $permissaoRepository,
        TelaRepositoryInterface $telaRepository,
        CargoRepositoryInterface $cargoRepository,
        SetorRepositoryInterface $setorRepository
    ) {
        $this->permissaoRepository = $permissaoRepository;
        $this->telaRepository = $telaRepository;
        $this->cargoRepository = $cargoRepository;
        $this->setorRepository = $setorRepository;

        $this->authorizeResource(Permissao::class, 'permissao');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $permissoes = $this->permissaoRepository->getPermissoesComRelacoes();
        $telas = $this->telaRepository->all();
        $cargos = $this->cargoRepository->all();
        $setores = $this->setorRepository->all();

        $cargosFiltrados = $cargos->filter(function($c) {
            return $c->nome !== 'Admin' && $c->nome !== 'Teste'; 
        });

        $setoresFiltrados = $setores->filter(function($s) {
            return $s->nome !== 'Admin' && $s->nome !== 'Teste';
        });

        return view('permissoes.index', compact('permissoes', 'cargosFiltrados', 'setoresFiltrados', 'telas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tela_id'  => 'required|exists:telas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'setor_id' => [
                'required',
                'exists:setores,id',
                function ($attribute, $value, $fail) use ($request) {

                    $exists = Permissao::where('tela_id', $request->tela_id)
                        ->where('cargo_id', $request->cargo_id)
                        ->where('setor_id', $request->setor_id)
                        ->exists();

                    if ($exists) {
                        $fail('Essa permissão já existe para esta tela, cargo e setor.');
                    }
                },
            ],
        ]);

        $data = $request->only('tela_id', 'cargo_id', 'setor_id');


        $this->permissaoRepository->create($data);

        return redirect()
            ->route('permissoes.index')
            ->with('success', 'Permissão criada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permissao $permissao): RedirectResponse
    {

        $this->permissaoRepository->delete($permissao);

        return redirect()->route('permissoes.index')->with('success', 'Permissão excluída com sucesso!');
    }
}