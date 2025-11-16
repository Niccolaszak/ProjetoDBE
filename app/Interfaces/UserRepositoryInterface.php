<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Usuários.
 */
interface UserRepositoryInterface
{
    /**
     * Retorna todos os usuários com seus cargos e setores.
     *
     * @return Collection
     */
    public function allWithCargoAndSetor(): Collection;

    /**
     * Cria um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Atualiza um usuário existente.
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool;

    /**
     * Exclui um usuário.
     *
     * @param User $user
     * @return bool|null
     */
    public function delete(User $user): ?bool;
}