<?php

namespace App\Interfaces;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Livros.
 */
interface LivroRepositoryInterface 
{
    /**
     * Retorna todos os livros, incluindo seus gêneros.
     *
     * @return Collection
     */
    public function allWithGenero(): Collection;

    /**
     * Cria um novo registro de livro.
     *
     * @param array $data
     * @return Livro
     */
    public function create(array $data): Livro;

    /**
     * Atualiza um livro existente.
     *
     * @param Livro $livro
     * @param array $data
     * @return bool
     */
    public function update(Livro $livro, array $data): bool;

    /**
     * Exclui um livro.
     *
     * @param Livro $livro
     * @return bool|null
     */
    public function delete(Livro $livro): ?bool;

    /**
     * Verifica se um livro possui movimentações associadas.
     * (Usado na lógica de negócio antes da exclusão)
     *
     * @param Livro $livro
     * @return bool
     */
    public function hasMovimentacoes(Livro $livro): bool;
}