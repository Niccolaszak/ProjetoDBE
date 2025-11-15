<?php

namespace App\Policies;

use App\Models\Permissao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de permissões.
     * Mapeia para a rota 'permissoes.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Permissões') || $user->can('Editar Permissões');
    }

    /**
     * Determina se o usuário pode criar permissões.
     * Mapeia para as rotas 'permissoes.create' e 'permissoes.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Permissões');
    }

    /**
     * Determina se o usuário pode excluir uma permissão.
     * Mapeia para a rota 'permissoes.destroy'.
     *
     */
    public function delete(User $user, Permissao $permissao): bool
    {
        return $user->can('Editar Permissões');
    }

    // --- Métodos Não Utilizados ---
    // Rotas 'show', 'edit' e 'update' não são usadas, então negamos por padrão.

    public function view(User $user, Permissao $permissao): bool
    {
        return false;
    }

    public function update(User $user, Permissao $permissao): bool
    {
        return false;
    }
}