<?php

namespace App\Core\Users\Commands;

/**
 * Command (DTO) para transportar os dados validados
 * para a criação de um novo usuário.
 */
class CreateUserCommand
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int $cargo_id
     * @param int $setor_id
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly int $cargo_id,
        public readonly int $setor_id
    ) {
    }
}