<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CargosController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Cargo::class, 'cargo');
    }

    /**
     * Lista todos os cargos.
     */
    public function index(): View
    {
        $cargos = Cargo::all();
        //$cargos = Cargo::whereNotIn('nome', ['Admin', 'Teste'])->get();
        return view('cargos.index', compact('cargos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cargos', 'nome'),
            ],
            'descricao' => ['nullable', 'string'],
        ]);

        Cargo::create($validated);

        return redirect()->route('cargos.index')->with('success', 'Cargo criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo): RedirectResponse
    {
        // Impede excluir se houver usuários vinculados
        if ($cargo->users()->exists()) {
            return redirect()
                ->route('cargos.index')
                ->with('error', 'Não é possível excluir este cargo, pois existem usuários vinculados a ele.');
        }

        // Impede excluir se houver permissões vinculadas
        if ($cargo->permissoes()->exists()) {
            return redirect()->route('cargos.index')->with('error', 'Não é possível excluir este cargo, pois existem permissões vinculadas a ele.');
        }

        $cargo->delete();

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }
} 