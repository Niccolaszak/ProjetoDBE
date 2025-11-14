<?php

namespace App\Core\Setores\Handlers;

use App\Core\Setores\Commands\DestroySetorCommand;
use LogicException; // Para erros de regra de negócio

/**
 * Handler (CQRS) responsável por executar a lógica
 * de exclusão de um Setor, aplicando regras de negócio.
 */
class DestroySetorHandler
{
    /**
     * Executa o comando de exclusão.
     *
     * @param DestroySetorCommand $command
     * @return void
     * @throws LogicException Se o setor não puder ser excluído.
     */
    public function __invoke(DestroySetorCommand $command): void
    {
        $setor = $command->setor;

        // Regra de Negócio: Verifica se existem usuários (funcionários) vinculados a este setor antes de permitir a exclusão.
        if ($setor->users()->exists()) {
            // Lança um erro de negócio que o Controller irá capturar
            throw new LogicException('Este setor possui usuários vinculados e não pode ser excluído.');
        }

        // Persistência: Exclui o setor
        $setor->delete();
    }
}