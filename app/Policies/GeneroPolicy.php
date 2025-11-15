<?php

namespace App\Policies;

use App\Models\Genero;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneroPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de gêneros.
     * Mapeia para a rota 'generos.index'.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Generos') || $user->can('Editar Generos');
    }

    /**
     * Determina se o usuário pode criar gêneros.
     * Mapeia para as rotas 'generos.create' e 'generos.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Generos');
    }

    /**
     * Determina se o usuário pode excluir um gênero.
     * Mapeia para a rota 'generos.destroy'.
     *
     */
    public function delete(User $user, Genero $genero): bool
    {
        return $user->can('Editar Generos');
    }

    // --- Métodos Não Utilizados ---
    // As rotas 'show', 'edit' e 'update' não são usadas por este controller,
    // mas deixamos os métodos na policy por padrão.
    // Se um dia a rota for ativada, eles negarão o acesso por padrão.

    public function view(User $user, Genero $genero): bool
    {
        return false; // Não usado, negado por padrão
    }

    public function update(User $user, Genero $genero): bool
    {
        return false; // Não usado, negado por padrão
    }
}