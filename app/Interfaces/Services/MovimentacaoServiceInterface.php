<?php

namespace App\Interfaces\Services;

use App\Models\Movimentacao;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o serviço de Movimentações.
 */
interface MovimentacaoServiceInterface
{
    public function listarMovimentacoes(): Collection;
    public function criarMovimentacao(array $dados): Movimentacao;
    public function excluirMovimentacao(Movimentacao $movimentacao): bool;
}