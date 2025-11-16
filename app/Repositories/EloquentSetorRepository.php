<?php

namespace App\Repositories;

use App\Interfaces\SetorRepositoryInterface;
use App\Models\Setor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do SetorRepositoryInterface.
 */
class EloquentSetorRepository implements SetorRepositoryInterface
{
    /**
     * Retorna todos os setores.
     */
    public function all(): Collection
    {
        return Setor::all();
    }

    /**
     * Cria um novo setor.
     */
    public function create(array $data): Setor
    {
        return Setor::create($data);
    }

    /**
     * Exclui um setor.
     */
    public function delete(Setor $setor): ?bool
    {
        return $setor->delete();
    }

    /**
     * Verifica se um setor possui usuários associados.
     */
    public function hasUsers(Setor $setor): bool
    {
        return $setor->users()->exists();
    }

    /**
     * Verifica se um setor possui permissões associadas.
     */
    public function hasPermissoes(Setor $setor): bool
    {

        if (method_exists($setor, 'permissoes')) {
            return $setor->permissoes()->exists();
        }
        return false;
    }
}