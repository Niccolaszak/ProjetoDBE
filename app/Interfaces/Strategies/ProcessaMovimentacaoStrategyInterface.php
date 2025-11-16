<?php

namespace App\Interfaces\Strategies;

use App\Models\Movimentacao;

/**
 * Define o contrato para uma estratégia de processamento de movimentação.
 */
interface ProcessaMovimentacaoStrategyInterface
{
    /**
     * Executa a lógica da movimentação (ex: criar registro, atualizar estoque).
     *
     * @param array $dados
     * @return Movimentacao
     * @throws \Exception
     */
    public function executar(array $dados): Movimentacao;
}