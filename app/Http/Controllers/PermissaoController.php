<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Core\Permissoes\Queries\ListarPermissoesQuery;
use App\Core\Permissoes\Commands\SincronizarPermissoesCommand;
use App\Core\Permissoes\Handlers\SincronizarPermissoesHandler;
use App\Core\Permissoes\Commands\RemoverPermissoesCargoCommand;
use App\Core\Permissoes\Handlers\RemoverPermissoesCargoHandler;

class PermissaoController extends Controller
{

    /**
     * Exibe a tela de gerenciamento de permissões.
     *
     * @param ListarPermissoesQuery $query
     * @return View
     */
    public function index(ListarPermissoesQuery $query): View
    {

        $data = $query->handle();

        return view('permissoes.index', $data);
    }

    /**
     * Sincroniza as permissões (telas) de um cargo.
     *
     * @param Request $request
     * @param SincronizarPermissoesHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, SincronizarPermissoesHandler $handler): RedirectResponse
    {
        // Validação
        $validated = $request->validate([
            'cargo_id' => 'required|integer|exists:cargos,id',
            'telas' => 'nullable|array',
            'telas.*' => 'integer|exists:telas,id',
        ]);

        // Se nenhum checkbox for marcado, 'telas' será nulo
        $telas = $validated['telas'] ?? [];

        // Cria o Command (DTO) para transportar os dados
        $command = new SincronizarPermissoesCommand(
            cargoId: (int) $validated['cargo_id'],
            telas: $telas
        );

        // O Handler executa a lógica de sincronização
        $handler($command);

        return redirect()->route('permissoes.index')->with('success', 'Permissões atualizadas com sucesso!');
    }

    /**
     * Remove todas as permissões de um cargo específico.
     *
     * @param string $id
     * @param RemoverPermissoesCargoHandler $handler
     * @return RedirectResponse
     */
    public function destroy(string $id, RemoverPermissoesCargoHandler $handler): RedirectResponse
    {
        // Cria o Command (DTO) com o ID vindo da rota
        $command = new RemoverPermissoesCargoCommand(cargoId: (int) $id);

        try {
            // O Handler executa a lógica de remoção
            $handler($command);

        } catch (ModelNotFoundException $e) {
            // Se o Handler não encontrar o cargo, o Controller trata o erro HTTP
            return redirect()->route('permissoes.index')->with('error', 'Cargo não encontrado.');
        }

        return redirect()->route('permissoes.index')->with('success', 'Permissões removidas com sucesso!');
    }
}