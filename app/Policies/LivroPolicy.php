<?php

namespace App\Policies;

use App\Models\Livro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LivroPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a listagem de livros.
     * Mapeia para a rota 'livros.index'.
     *
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Consultar Livros') || $user->can('Editar Livros');
    }

    /**
     * Determina se o usuário pode ver um livro específico.
     * Mapeia para a rota 'livros.show'.
     */
    public function view(User $user, Livro $livro): bool
    {
        return $user->can('Consultar Livros') || $user->can('Editar Livros');
    }

    /**
     * Determina se o usuário pode criar livros.
     * Mapeia para as rotas 'livros.create' e 'livros.store'.
     *
     */
    public function create(User $user): bool
    {
        return $user->can('Editar Livros');
    }

    /**
     * Determina se o usuário pode atualizar um livro.
     * Mapeia para as rotas 'livros.edit' e 'livros.update'.
     *
     */
    public function update(User $user, Livro $livro): bool
    {
        return $user->can('Editar Livros');
    }

    /**
     * Determina se o usuário pode excluir um livro.
     * Mapeia para a rota 'livros.destroy'.
     *
     */
    public function delete(User $user, Livro $livro): bool
    {
        return $user->can('Editar Livros');
    }
}