<?php

namespace App\Services;

use App\Interfaces\Strategies\ProcessaMovimentacaoStrategyInterface;
use App\Services\Strategies\ProcessaEntradaStrategy;
use App\Services\Strategies\ProcessaSaidaStrategy;
use Exception;

/**
 * Factory para criar a estratégia de movimentação correta
 * com base no tipo ('entrada' ou 'saida').
 */
class MovimentacaoStrategyFactory
{
    /**
     * Cria e retorna a instância da Strategy correta.
     *
     * @param string $tipo 'entrada' ou 'saida'
     * @return ProcessaMovimentacaoStrategyInterface
     * @throws Exception Se o tipo for inválido
     */
    public function make(string $tipo): ProcessaMovimentacaoStrategyInterface
    {
        if ($tipo === 'entrada') {
            // O Service Container (app()) resolve as dependências
            // (MovimentacaoRepository, EstoqueRepository) para nós.
            return app(ProcessaEntradaStrategy::class);
        }

        if ($tipo === 'saida') {
            return app(ProcessaSaidaStrategy::class);
        }

        throw new Exception("Tipo de movimentação desconhecido: $tipo");
    }
}