<?php

namespace App\Policies;

use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FornecedorPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de fornecedores.
     * Mapeia para a rota 'fornecedores.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Fornecedores') || $user->can('Editar Fornecedores');
    }

    /**
     * Determina se o usuário pode criar fornecedores.
     * Mapeia para a rota 'fornecedores.store'. (A rota 'create' não é usada).
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Fornecedores');
    }

    /**
     * Determina se o usuário pode atualizar um fornecedor.
     * Mapeia para a rota 'fornecedores.update'. (A rota 'edit' não é usada).
     *
     */
    public function update(User $user, Fornecedor $fornecedor): bool
    {
        return $user->can('Editar Fornecedores');
    }

    /**
     * Determina se o usuário pode excluir um fornecedor.
     * Mapeia para a rota 'fornecedores.destroy'.
     *
     */
    public function delete(User $user, Fornecedor $fornecedor): bool
    {
        return $user->can('Editar Fornecedores');
    }

    // --- Métodos Não Utilizados ---
    // A rota 'show' não é usada.
    public function view(User $user, Fornecedor $fornecedor): bool
    {
        return false;
    }
}