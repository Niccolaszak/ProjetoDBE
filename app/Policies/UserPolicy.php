<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de usuários.
     * Mapeia para a rota 'users.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Usuários') 
            || $user->can('Registrar Usuários')
            || $user->can('Editar Usuários');
    }

    /**
     * Determina se o usuário pode criar usuários.
     * Mapeia para as rotas 'users.create' e 'users.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Registrar Usuários');
    }

    /**
     * Determina se o usuário pode atualizar um usuário.
     * Mapeia para a rota 'users.update'.
     *
     */
    public function update(User $user, User $model): bool
    {
        return $user->can('Editar Usuários');
    }

    /**
     * Determina se o usuário pode excluir um usuário.
     * Mapeia para a rota 'users.destroy'.
     *
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can('Editar Usuários');
    }

    // --- Métodos Não Utilizados ---
    // Rotas 'show' e 'edit' não são usadas, então negamos por padrão.

    public function view(User $user, User $model): bool
    {
        return false;
    }
}