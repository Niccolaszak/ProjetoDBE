<?php

namespace App\Policies;

use App\Models\Estoque;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstoquePolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de estoque.
     * Mapeia para a rota 'estoques.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Estoque');
    }

    // --- Métodos Não Utilizados ---
    // Todas as outras ações são negadas por padrão

    public function view(User $user, Estoque $estoque): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Estoque $estoque): bool
    {
        return false;
    }

    public function delete(User $user, Estoque $estoque): bool
    {
        return false;
    }
}