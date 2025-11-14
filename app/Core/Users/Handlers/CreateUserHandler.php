<?php

namespace App\Core\Users\Handlers;

use App\Core\Users\Commands\CreateUserCommand;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de criação de um novo usuário.
 */
class CreateUserHandler
{
    /**
     * Executa o comando de criação.
     *
     * @param CreateUserCommand $command
     * @return User
     */
    public function __invoke(CreateUserCommand $command): User
    {
        // A lógica de negócio (hashing) e persistência
        $user = User::create([
            'name' => $command->name,
            'email' => $command->email,
            'password' => Hash::make($command->password),
            'cargo_id' => $command->cargo_id,
            'setor_id' => $command->setor_id,
            // 'forcar_redefinir_senha' é 'true' por padrão (definido na migração)
        ]);

        return $user;
    }
}