<?php

namespace App\Repositories;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do FornecedorRepositoryInterface.
 */
class EloquentFornecedorRepository implements FornecedorRepositoryInterface
{
    /**
     * Retorna todos os fornecedores.
     */
    public function all(): Collection
    {
        return Fornecedor::all();
    }

    /**
     * Retorna um fornecedor.
     */
    public function find(int $id): ?Fornecedor
    {
        return Fornecedor::find($id);
    }

    /**
     * Cria um novo fornecedor.
     */
    public function create(array $data): Fornecedor
    {
        return Fornecedor::create($data);
    }

    /**
     * Atualiza um fornecedor existente.
     */
    public function update(Fornecedor $fornecedor, array $data): bool
    {
        return $fornecedor->update($data);
    }

    /**
     * Exclui um fornecedor.
     */
    public function delete(Fornecedor $fornecedor): ?bool
    {
        return $fornecedor->delete();
    }

    /**
     * Verifica se um fornecedor possui movimentações associadas.
     */
    public function hasMovimentacoes(Fornecedor $fornecedor): bool
    {
        return $fornecedor->movimentacoes()->exists();
    }
}