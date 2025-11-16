<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do UserRepositoryInterface.
 */
class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Retorna todos os usuários com seus cargos e setores.
     */
    public function allWithCargoAndSetor(): Collection
    {
        return User::with(['cargo', 'setor'])->get();
    }

    /**
     * Cria um novo usuário.
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Atualiza um usuário existente.
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Exclui um usuário.
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}