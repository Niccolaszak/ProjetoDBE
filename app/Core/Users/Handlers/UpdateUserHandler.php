<?php

namespace App\Core\Users\Handlers;

use App\Core\Users\Commands\UpdateUserCommand;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de atualização de um usuário existente.
 */
class UpdateUserHandler
{
    /**
     * Executa o comando de atualização.
     * @param UpdateUserCommand $command
     * @return User
     */
    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $command->user;

        // Prepara o array de dados principais para a atualização
        $data = [
            'name' => $command->name,
            'email' => $command->email,
            'cargo_id' => $command->cargo_id,
            'setor_id' => $command->setor_id,
            'forcar_redefinir_senha' => $command->forcar_redefinir_senha,
        ];

        // Regra de Negócio: A senha só deve ser atualizada se um novo valor não-nulo for fornecido.
        if (!empty($command->password)) {
            $data['password'] = Hash::make($command->password);
        }

        // Persiste os dados no banco
        $user->update($data);

        return $user;
    }
}