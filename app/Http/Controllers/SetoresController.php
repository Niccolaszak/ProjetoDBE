<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SetoresController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Setor::class, 'setor');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $setores = Setor::all();
        //$setores = Setor::whereNotIn('nome', ['Admin', 'Teste'])->get();
        return view('setores.index', compact('setores'));
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
                Rule::unique('setores', 'nome'),
            ],
            'descricao' => ['nullable', 'string'],
        ]);

        Setor::create($validated);

        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setor $setor): RedirectResponse
    {
        // Impede excluir se houver usuários vinculados
        if ($setor->users()->exists()) {
            return redirect()->route('setores.index')->with('error', 'Não é possível excluir este setor, pois existem usuários vinculados a ele.');
        }

        // Impede excluir se houver permissões vinculadas
        if (method_exists($setor, 'permissoes') && $setor->permissoes()->exists()) {
            return redirect()->route('setores.index')->with('error', 'Não é possível excluir este setor, pois existem permissões vinculadas a ele.');
        }

        $setor->delete();

        return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
    }
}