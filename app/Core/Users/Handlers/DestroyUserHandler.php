<?php

namespace App\Core\Users\Handlers;

use App\Core\Users\Commands\DestroyUserCommand;
use LogicException;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de exclusão de um usuário, aplicando regras de negócio.
 */
class DestroyUserHandler
{
    /**
     * Executa o comando de exclusão.
     *
     * @param DestroyUserCommand $command
     * @return void
     * @throws LogicException Se uma regra de negócio impedir a exclusão.
     */
    public function __invoke(DestroyUserCommand $command): void
    {
        $userToDelete = $command->userToDelete;
        $authenticatedUser = $command->authenticatedUser;

        // Regra de Negócio 1: Ninguém pode excluir a si mesmo.
        if ($userToDelete->id === $authenticatedUser->id) {
            throw new LogicException('Você não pode excluir seu próprio usuário.');
        }

        // Regra de Negócio 2: Ninguém pode excluir o usuário "admin" criado na migração.
        if ($userToDelete->email === 'admin@admin.com') {
            throw new LogicException('Não é permitido excluir o usuário Administrador principal.');
        }

        // Regra de Negócio 3: Ninguém pode excluir um usuário que possui movimentações.
        if ($userToDelete->movimentacoes()->exists()) {
           throw new LogicException('Este usuário possui movimentações e não pode ser excluído.');
        }

        // Persistência: Exclui o usuário
        $userToDelete->delete();
    }
}