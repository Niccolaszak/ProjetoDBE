<?php

namespace App\Core\Permissoes\Handlers;

use App\Core\Permissoes\Commands\RemoverPermissoesCargoCommand;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Handler (CQRS) responsável por executar a lógica de
 * remoção de todas as permissões de um cargo.
 */
class RemoverPermissoesCargoHandler
{
    /**
     * Executa o comando de remoção.
     *
     * @param RemoverPermissoesCargoCommand $command
     * @return void
     */
    public function __invoke(RemoverPermissoesCargoCommand $command): void
    {
        $cargo = Cargo::find($command->cargoId);

        if (!$cargo) {
            throw new ModelNotFoundException("Cargo com ID {$command->cargoId} não encontrado.");
        }

        $cargo->permissoes()->detach();
    }
}