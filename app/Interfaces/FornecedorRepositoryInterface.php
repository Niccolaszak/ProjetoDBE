<?php

namespace App\Interfaces;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Fornecedores.
 */
interface FornecedorRepositoryInterface
{
    /**
     * Retorna todos os fornecedores.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retorna um fornecedor.
     *
     * @return Fornecedor
     */
    public function find(int $id): ?Fornecedor;

    /**
     * Cria um novo fornecedor.
     *
     * @param array $data
     * @return Fornecedor
     */
    public function create(array $data): Fornecedor;

    /**
     * Atualiza um fornecedor existente.
     *
     * @param Fornecedor $fornecedor
     * @param array $data
     * @return bool
     */
    public function update(Fornecedor $fornecedor, array $data): bool;

    /**
     * Exclui um fornecedor.
     *
     * @param Fornecedor $fornecedor
     * @return bool|null
     */
    public function delete(Fornecedor $fornecedor): ?bool;

    /**
     * Verifica se um fornecedor possui movimentações associadas.
     *
     * @param Fornecedor $fornecedor
     * @return bool
     */
    public function hasMovimentacoes(Fornecedor $fornecedor): bool;
}