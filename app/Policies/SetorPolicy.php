<?php

namespace App\Policies;

use App\Models\Setor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SetorPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de setores.
     * Mapeia para a rota 'setores.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Setores') || $user->can('Editar Setores');
    }

    /**
     * Determina se o usuário pode criar setores.
     * Mapeia para as rotas 'setores.create' e 'setores.store'.
     * 
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Setores');
    }

    /**
     * Determina se o usuário pode excluir um setor.
     * Mapeia para a rota 'setores.destroy'.
     *
     */
    public function delete(User $user, Setor $setor): bool
    {
        return $user->can('Editar Setores');
    }

    // --- Métodos Não Utilizados ---
    // Rotas 'show', 'edit' e 'update' não são usadas, então negamos por padrão.

    public function view(User $user, Setor $setor): bool
    {
        return false;
    }

    public function update(User $user, Setor $setor): bool
    {
        return false;
    }
}