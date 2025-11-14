<?php

namespace App\Core\Cargos\Handlers;

use App\Core\Cargos\Commands\DestroyCargoCommand;
use LogicException;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de exclusão de um Cargo, aplicando regras de negócio.
 */
class DestroyCargoHandler
{
    /**
     * Executa o comando de exclusão.
     *
     * @param DestroyCargoCommand $command
     * @return void
     * @throws LogicException Se o cargo não puder ser excluído.
     */
    public function __invoke(DestroyCargoCommand $command): void
    {
        $cargo = $command->cargo;

        // Regra de Negócio: Verifica se existem usuários (funcionários)
        // vinculados a este cargo antes de permitir a exclusão.
        if ($cargo->users()->exists()) {
            // Lança um erro de negócio que o Controller irá capturar
            throw new LogicException('Este cargo possui usuários vinculados e não pode ser excluído.');
        }

        // Persistência: Exclui o cargo
        $cargo->delete();
    }
}