<?php
// app/Domain/Movimentacao/MovimentacaoContext.php
namespace App\Domain\Movimentacao;

use App\Models\Movimentacao;

/**
 * O Contexto mantém uma referência à Strategy e a delega
 * a execução do algoritmo.
 */
class MovimentacaoContext
{
    private MovimentacaoStrategy $strategy;

    public function setStrategy(MovimentacaoStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function processarMovimentacao(Movimentacao $movimentacao): void
    {
        if (!isset($this->strategy)) {
            throw new \LogicException("A estratégia de movimentação não foi definida.");
        }
        $this->strategy->processar($movimentacao);
    }

    public function reverterMovimentacao(Movimentacao $movimentacao): void
    {
        if (!isset($this->strategy)) {
            throw new \LogicException("A estratégia de movimentação não foi definida.");
        }
        $this->strategy->reverter($movimentacao);
    }
}