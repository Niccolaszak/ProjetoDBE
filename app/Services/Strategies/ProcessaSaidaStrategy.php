<?php

namespace App\Services\Strategies;

use App\Interfaces\Strategies\ProcessaMovimentacaoStrategyInterface;
use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Models\Movimentacao;
use Exception;

/**
 * Estratégia para processar uma movimentação de SAÍDA.
 * A lógica é VERIFICAR o estoque, criar a movimentação e SUBTRAIR do estoque.
 */
class ProcessaSaidaStrategy implements ProcessaMovimentacaoStrategyInterface
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

        $estoque = $this->estoqueRepository->findOrCreateByLivroId($dados['livro_id']);

        if ($estoque->quantidade_disponivel < $dados['quantidade']) {
            throw new Exception('Não é possível registrar saída. Estoque insuficiente!');
        }

        return $this->movimentacaoRepository->create($dados);
    }
}