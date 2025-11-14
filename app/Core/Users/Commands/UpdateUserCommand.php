<?php

namespace App\Core\Users\Commands;

use App\Models\User;

/**
 * Command (DTO) para transportar os dados validados
 * para a atualização de um usuário existente.
 */
class UpdateUserCommand
{
    /**
     * @param User $user
     * @param string $name
     * @param string $email
     * @param int $cargo_id
     * @param int $setor_id
     * @param bool $forcar_redefinir_senha Flag para forçar redefinição no próximo login.
     * @param string|null $password A nova senha (opcional, em texto plano).
     */
    public function __construct(
        public readonly User $user,
        public readonly string $name,
        public readonly string $email,
        public readonly int $cargo_id,
        public readonly int $setor_id,
        public readonly bool $forcar_redefinir_senha,
        public readonly ?string $password // A senha pode ser nula
    ) {
    }
}