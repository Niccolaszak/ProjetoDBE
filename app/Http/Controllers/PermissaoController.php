<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Models\Cargo;
use App\Models\Setor;
use App\Models\Tela;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissaoController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Permissao::class, 'permissao');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        
        $permissoes = Permissao::with(['tela', 'cargo', 'setor'])
            ->whereHas('cargo', function($q) {
                    $q->where('nome', '!=', 'Admin');
                })
            ->get();
        $telas = Tela::all();
        $cargos = Cargo::all();
        $setores = Setor::all();

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
        // Validação
        $request->validate([
            'tela_id'  => 'required|exists:telas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'setor_id' => [
                'required',
                'exists:setores,id',
                function ($attribute, $value, $fail) use ($request) {
                    // Previne duplicacao
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

        // Dados principais
        $data = $request->only('tela_id', 'cargo_id', 'setor_id');

        // Cria a permissão principal
        Permissao::create($data);

        return redirect()
            ->route('permissoes.index')
            ->with('success', 'Permissão criada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permissao $permissao): RedirectResponse
    {

        $permissao->delete();

        return redirect()->route('permissoes.index')->with('success', 'Permissão excluída com sucesso!');
    }
}