<?php

namespace App\Repositories;

use App\Interfaces\CargoRepositoryInterface;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do CargoRepositoryInterface.
 */
class EloquentCargoRepository implements CargoRepositoryInterface
{
    /**
     * Retorna todos os cargos.
     */
    public function all(): Collection
    {
        return Cargo::all();
    }

    /**
     * Cria um novo cargo.
     */
    public function create(array $data): Cargo
    {
        return Cargo::create($data);
    }

    /**
     * Exclui um cargo.
     */
    public function delete(Cargo $cargo): ?bool
    {
        return $cargo->delete();
    }

    /**
     * Verifica se um cargo possui usuários associados.
     */
    public function hasUsers(Cargo $cargo): bool
    {
        return $cargo->users()->exists();
    }

    /**
     * Verifica se um cargo possui permissões associadas.
     */
    public function hasPermissoes(Cargo $cargo): bool
    {
        return $cargo->permissoes()->exists();
    }
}