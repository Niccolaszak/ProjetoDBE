<?php

namespace App\Interfaces;

use App\Models\Setor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Setores.
 */
interface SetorRepositoryInterface
{
    /**
     * Retorna todos os setores.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Cria um novo setor.
     *
     * @param array $data
     * @return Setor
     */
    public function create(array $data): Setor;

    /**
     * Exclui um setor.
     *
     * @param Setor $setor
     * @return bool|null
     */
    public function delete(Setor $setor): ?bool;

    /**
     * Verifica se um setor possui usuários associados.
     *
     * @param Setor $setor
     * @return bool
     */
    public function hasUsers(Setor $setor): bool;

    /**
     * Verifica se um setor possui permissões associadas.
     *
     * @param Setor $setor
     * @return bool
     */
    public function hasPermissoes(Setor $setor): bool;
}