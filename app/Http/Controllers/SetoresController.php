<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Interfaces\SetorRepositoryInterface;

class SetoresController extends Controller
{
    private SetorRepositoryInterface $setorRepository;
    
    public function __construct(SetorRepositoryInterface $setorRepository)
    {
        $this->setorRepository = $setorRepository;
        $this->authorizeResource(Setor::class, 'setor');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $setores = $this->setorRepository->all();
        
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

        $this->setorRepository->create($validated);

        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setor $setor): RedirectResponse
    {
        if ($this->setorRepository->hasUsers($setor)) {
            return redirect()->route('setores.index')->with('error', 'Não é possível excluir este setor, pois existem usuários vinculados a ele.');
        }

        if ($this->setorRepository->hasPermissoes($setor)) {
            return redirect()->route('setores.index')->with('error', 'Não é possível excluir este setor, pois existem permissões vinculadas a ele.');
        }

        $this->setorRepository->delete($setor);

        return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
    }
}