<?php

namespace App\Interfaces;

use App\Models\Movimentacao;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Movimentações.
 */
interface MovimentacaoRepositoryInterface
{
    /**
     * Retorna todas as movimentações com seus livros e usuários.
     *
     * @return Collection
     */
    public function allWithLivroAndUser(): Collection;

    /**
     * Cria uma nova movimentação.
     *
     * @param array $data
     * @return Movimentacao
     */
    public function create(array $data): Movimentacao;

    /**
     * Exclui uma movimentação.
     *
     * @param Movimentacao $movimentacao
     * @return bool|null
     */
    public function delete(Movimentacao $movimentacao): ?bool;
}