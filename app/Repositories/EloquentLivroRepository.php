<?php

namespace App\Repositories;

use App\Interfaces\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do LivroRepositoryInterface.
 * Gerencia a lógica de acesso aos dados para o modelo Livro.
 */
class EloquentLivroRepository implements LivroRepositoryInterface
{
    /**
     * Retorna todos os livros, incluindo seus gêneros.
     */
    public function allWithGenero(): Collection
    {
        return Livro::with('genero')->get();
    }

    /**
     * Cria um novo registro de livro.
     */
    public function create(array $data): Livro
    {
        return Livro::create($data);
    }

    /**
     * Atualiza um livro existente.
     */
    public function update(Livro $livro, array $data): bool
    {
        return $livro->update($data);
    }

    /**
     * Exclui um livro.
     */
    public function delete(Livro $livro): ?bool
    {
        return $livro->delete();
    }

    /**
     * Verifica se um livro possui movimentações associadas.
     * Esta verificação é usada pelo Service (que faremos na Fase 2)
     * para decidir se a exclusão pode ocorrer.
     */
    public function hasMovimentacoes(Livro $livro): bool
    {
        return $livro->movimentacoes()->exists();
    }
}