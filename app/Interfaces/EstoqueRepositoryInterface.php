<?php

namespace App\Interfaces;

use App\Models\Estoque;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Estoque.
 */
interface EstoqueRepositoryInterface
{
    /**
     * Retorna todos os registros de estoque com livro e gênero.
     *
     * @return Collection
     */
    public function allWithLivroGenero(): Collection;

    /**
     * Busca um registro de estoque pelo livro_id ou cria um novo.
     *
     * @param int $livroId
     * @return Estoque
     */
    public function findOrCreateByLivroId(int $livroId): Estoque;

    /**
     * Salva o estado do registro de estoque.
     *
     * @param Estoque $estoque
     * @return bool
     */
    public function save(Estoque $estoque): bool;
}