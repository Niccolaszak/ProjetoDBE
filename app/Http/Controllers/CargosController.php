<?php

namespace App\Http\Controllers;

use App\Models\Cargo; // Route-Model-Binding
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LogicException; // Para capturar erros de negócio
use App\Core\Cargos\Queries\ListarCargosQuery;
use App\Core\Cargos\Commands\CreateCargoCommand;
use App\Core\Cargos\Handlers\CreateCargoHandler;
use App\Core\Cargos\Commands\DestroyCargoCommand;
use App\Core\Cargos\Handlers\DestroyCargoHandler;

/**
 * Controller para o CRUD de Cargos.
 */
class CargosController extends Controller
{
    /**
     * Exibe a lista de cargos.
     *
     * @param ListarCargosQuery $query
     * @return View
     */
    public function index(ListarCargosQuery $query): View
    {
        $data = $query->handle();

        return view('cargos.index', $data);
    }

    /**
     * Valida e armazena um novo cargo.
     * @param Request $request
     * @param CreateCargoHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, CreateCargoHandler $handler): RedirectResponse
    {
        $validated = $request->validate([
            'cargo' => 'required|string|max:100|unique:cargos,cargo',
            'salario' => 'required|numeric|min:0',
        ]);

        $command = new CreateCargoCommand(
            cargo: $validated['cargo'],
            salario: (float) $validated['salario']
        );

        $handler($command);

        return redirect()->route('cargos.index')->with('success', 'Cargo criado com sucesso!');
    }

    /**
     * Remove um cargo existente.
     * @param Cargo $cargo (Injetado pela Rota-Model-Binding)
     * @param DestroyCargoHandler $handler
     * @return RedirectResponse
     */
    public function destroy(Cargo $cargo, DestroyCargoHandler $handler): RedirectResponse
    {
        try {
            // O Command transporta o modelo a ser excluído
            $command = new DestroyCargoCommand(cargo: $cargo);
            
            // O Handler executa a verificação e a exclusão
            $handler($command);

        } catch (LogicException $e) {
            // Captura o erro de negócio (ex: "Cargo possui usuários")
            return redirect()->route('cargos.index')->with('error', $e->getMessage());
        }

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }
}