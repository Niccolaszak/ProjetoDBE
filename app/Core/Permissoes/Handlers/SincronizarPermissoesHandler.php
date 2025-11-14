<?php

namespace App\Core\Permissoes\Handlers;

use App\Core\Permissoes\Commands\SincronizarPermissoesCommand;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Handler (CQRS) responsável por executar a lógica de
 * sincronização de permissões de um cargo.
 */
class SincronizarPermissoesHandler
{
    /**
     * Executa o comando de sincronização.
     *
     * @param SincronizarPermissoesCommand $command
     * @return void
     */
    public function __invoke(SincronizarPermissoesCommand $command): void
    {
        $cargo = Cargo::find($command->cargoId);

        if (!$cargo) {
            throw new ModelNotFoundException("Cargo com ID {$command->cargoId} não encontrado.");
        }

        $cargo->permissoes()->sync($command->telas);
    }
}