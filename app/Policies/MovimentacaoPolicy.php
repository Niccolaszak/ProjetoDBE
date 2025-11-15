<?php

namespace App\Policies;

use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovimentacaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de movimentações.
     * Mapeia para a rota 'movimentacoes.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Movimentações') || $user->can('Editar Movimentações');
    }

    /**
     * Determina se o usuário pode criar movimentações.
     * Mapeia para as rotas 'movimentacoes.create' e 'movimentacoes.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Movimentações');
    }

    /**
     * Determina se o usuário pode excluir uma movimentação.
     * Mapeia para a rota 'movimentacoes.destroy'.
     *
     */
    public function delete(User $user, Movimentacao $movimentacao): bool
    {
        return $user->can('Editar Movimentações');
    }

    // --- Métodos Não Utilizados ---
    // Rotas 'show', 'edit' e 'update' não são usadas, então negamos por padrão.

    public function view(User $user, Movimentacao $movimentacao): bool
    {
        return false;
    }

    public function update(User $user, Movimentacao $movimentacao): bool
    {
        return false;
    }
}