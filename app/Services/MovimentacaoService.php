<?php
// app/Services/MovimentacaoService.php
namespace App\Services;

use App\Domain\Movimentacao\MovimentacaoContext;
use App\Domain\Movimentacao\MovimentacaoStrategy;
use App\Domain\Movimentacao\Strategies\EntradaStrategy;
use App\Domain\Movimentacao\Strategies\SaidaStrategy;
use App\Models\Movimentacao;
use InvalidArgumentException;

class MovimentacaoService
{
    public function __construct(protected MovimentacaoContext $contexto)
    {
    }

    /**
     * Processa uma nova movimentação.
     */
    public function processar(Movimentacao $movimentacao): void
    {
    
        $strategy = $this->getStrategyInstance($movimentacao->tipo);

        $this->contexto->setStrategy($strategy);

        $this->contexto->processarMovimentacao($movimentacao);
    }

    /**
     * Reverte uma movimentação que está sendo excluída.
     */
    public function reverter(Movimentacao $movimentacao): void
    {

        $strategy = $this->getStrategyInstance($movimentacao->tipo);

        $this->contexto->setStrategy($strategy);

        $this->contexto->reverterMovimentacao($movimentacao);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getStrategyInstance(string $tipo): MovimentacaoStrategy
    {
        return match (strtolower($tipo)) {
            'entrada' => new EntradaStrategy(),
            'saida'   => new SaidaStrategy(),
            default => throw new InvalidArgumentException("Tipo de movimentação inválido: {$tipo}."),
        };
    }
}