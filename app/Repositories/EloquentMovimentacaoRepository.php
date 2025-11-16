<?php

namespace App\Repositories;

use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Models\Movimentacao;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do MovimentacaoRepositoryInterface.
 */
class EloquentMovimentacaoRepository implements MovimentacaoRepositoryInterface
{
    /**
     * Retorna todas as movimentações com seus livros e usuários.
     */
    public function allWithLivroAndUser(): Collection
    {
        return Movimentacao::with(['livro', 'user'])->latest()->get();
    }

    /**
     * Cria uma nova movimentação.
     */
    public function create(array $data): Movimentacao
    {
        return Movimentacao::create($data);
    }

    /**
     * Exclui uma movimentação.
     */
    public function delete(Movimentacao $movimentacao): ?bool
    {
        return $movimentacao->delete();
    }
}