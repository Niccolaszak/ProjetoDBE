<?php

namespace App\Interfaces;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Cargos.
 */
interface CargoRepositoryInterface
{
    /**
     * Retorna todos os cargos.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Cria um novo cargo.
     *
     * @param array $data
     * @return Cargo
     */
    public function create(array $data): Cargo;

    /**
     * Exclui um cargo.
     *
     * @param Cargo $cargo
     * @return bool|null
     */
    public function delete(Cargo $cargo): ?bool;

    /**
     * Verifica se um cargo possui usuários associados.
     *
     * @param Cargo $cargo
     * @return bool
     */
    public function hasUsers(Cargo $cargo): bool;

    /**
     * Verifica se um cargo possui permissões associadas.
     *
     * @param Cargo $cargo
     * @return bool
     */
    public function hasPermissoes(Cargo $cargo): bool;
}