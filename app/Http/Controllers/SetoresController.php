<?php

namespace App\Http\Controllers;

use App\Models\Setor; // Route-Model-Binding
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LogicException; // Para capturar erros de negócio
use App\Core\Setores\Queries\ListarSetoresQuery;
use App\Core\Setores\Commands\CreateSetorCommand;
use App\Core\Setores\Handlers\CreateSetorHandler;
use App\Core\Setores\Commands\DestroySetorCommand;
use App\Core\Setores\Handlers\DestroySetorHandler;

/**
 * Controller para o CRUD de Setores.
 */
class SetoresController extends Controller
{
    /**
     * Exibe a lista de setores.
     *
     * @param ListarSetoresQuery $query
     * @return View
     */
    public function index(ListarSetoresQuery $query): View
    {
        $data = $query->handle();

        return view('setores.index', $data);
    }

    /**
     * Valida e armazena um novo setor.
     * @param Request $request
     * @param CreateSetorHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, CreateSetorHandler $handler): RedirectResponse
    {
        $validated = $request->validate([
            'setor' => 'required|string|max:100|unique:setores,setor',
        ]);

        $command = new CreateSetorCommand(
            setor: $validated['setor']
        );

        $handler($command);

        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }

    /**
     * Remove um setor existente.
     * @param Setor $setor (Injetado pela Rota-Model-Binding)
     * @param DestroySetorHandler $handler
     * @return RedirectResponse
     */
    public function destroy(Setor $setor, DestroySetorHandler $handler): RedirectResponse
    {
        try {
            // O Command transporta o modelo a ser excluído
            $command = new DestroySetorCommand(setor: $setor);
            
            // O Handler executa a verificação e a exclusão
            $handler($command);

        } catch (LogicException $e) {
            // Captura o erro de negócio (ex: "Setor possui usuários")
            return redirect()->route('setores.index')->with('error', $e->getMessage());
        }

        return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
    }
}