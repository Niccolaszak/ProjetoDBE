<?php

namespace App\Repositories;

use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Estoque;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do EstoqueRepositoryInterface.
 */
class EloquentEstoqueRepository implements EstoqueRepositoryInterface
{
    /**
     * Retorna todos os registros de estoque com livro e gênero.
     */
    public function allWithLivroGenero(): Collection
    {
        return Estoque::with('livro.genero')->get();
    }

    /**
     * Busca um registro de estoque pelo livro_id ou cria um novo.
     */
    public function findOrCreateByLivroId(int $livroId): Estoque
    {
        return Estoque::firstOrNew(['livro_id' => $livroId]);
    }

    /**
     * Salva o estado do registro de estoque.
     */
    public function save(Estoque $estoque): bool
    {
        return $estoque->save();
    }
}