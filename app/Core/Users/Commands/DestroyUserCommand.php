<?php

namespace App\Core\Users\Commands;

use App\Models\User;

/**
 * Command (DTO) para transportar os dados necessários
 * para a exclusão de um usuário.
 */
class DestroyUserCommand
{
    /**
     * @param User $userToDelete
     * @param User $authenticatedUser
     */
    public function __construct(
        public readonly User $userToDelete,
        public readonly User $authenticatedUser
    ) {
    }
}