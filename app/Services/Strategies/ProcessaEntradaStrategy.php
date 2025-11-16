<?php

namespace App\Services\Strategies;

use App\Interfaces\Strategies\ProcessaMovimentacaoStrategyInterface;
use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Movimentacao;

/**
 * Estratégia para processar uma movimentação de ENTRADA.
 * A lógica é criar a movimentação e ADICIONAR ao estoque.
 */
class ProcessaEntradaStrategy implements ProcessaMovimentacaoStrategyInterface
{
    private MovimentacaoRepositoryInterface $movimentacaoRepository;
    private EstoqueRepositoryInterface $estoqueRepository;

    public function __construct(
        MovimentacaoRepositoryInterface $movimentacaoRepository,
        EstoqueRepositoryInterface $estoqueRepository
    ) {
        $this->movimentacaoRepository = $movimentacaoRepository;
        $this->estoqueRepository = $estoqueRepository;
    }

    public function executar(array $dados): Movimentacao
    {
        return $this->movimentacaoRepository->create($dados);
    }
}