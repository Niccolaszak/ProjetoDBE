<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Interfaces\CargoRepositoryInterface;

class CargosController extends Controller
{
    private CargoRepositoryInterface $cargoRepository;

    public function __construct(CargoRepositoryInterface $cargoRepository)
    {
        $this->cargoRepository = $cargoRepository;
        $this->authorizeResource(Cargo::class, 'cargo');
    }

    /**
     * Lista todos os cargos.
     */
    public function index(): View
    {

        $cargos = $this->cargoRepository->all();
        
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

        $this->cargoRepository->create($validated);

        return redirect()->route('cargos.index')->with('success', 'Cargo criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo): RedirectResponse
    {

        if ($this->cargoRepository->hasUsers($cargo)) {
            return redirect()
                ->route('cargos.index')
                ->with('error', 'Não é possível excluir este cargo, pois existem usuários vinculados a ele.');
        }

        if ($this->cargoRepository->hasPermissoes($cargo)) {
            return redirect()->route('cargos.index')->with('error', 'Não é possível excluir este cargo, pois existem permissões vinculadas a ele.');
        }

        $this->cargoRepository->delete($cargo);

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }
}