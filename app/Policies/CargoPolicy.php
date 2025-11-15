<?php

namespace App\Policies;

use App\Models\Cargo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CargoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de cargos.
     * Mapeia para a rota 'cargos.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Cargos') || $user->can('Editar Cargos');
    }

    /**
     * Determina se o usuário pode criar cargos.
     * Mapeia para as rotas 'cargos.create' e 'cargos.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Cargos');
    }

    /**
     * Determina se o usuário pode excluir um cargo.
     * Mapeia para a rota 'cargos.destroy'.
     *
     */
    public function delete(User $user, Cargo $cargo): bool
    {
        return $user->can('Editar Cargos');
    }

    // --- Métodos Não Utilizados ---
    // Rotas 'show', 'edit' e 'update' não são usadas, então negamos por padrão.

    public function view(User $user, Cargo $cargo): bool
    {
        return false;
    }

    public function update(User $user, Cargo $cargo): bool
    {
        return false;
    }
}