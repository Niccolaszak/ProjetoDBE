<?php

namespace App\Services;

use App\Interfaces\Services\MovimentacaoServiceInterface;
use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Movimentacao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\MovimentacaoStrategyFactory;

class MovimentacaoService implements MovimentacaoServiceInterface
{
    private MovimentacaoRepositoryInterface $movimentacaoRepository;
    private FornecedorRepositoryInterface $fornecedorRepository;
    private MovimentacaoStrategyFactory $strategyFactory;

    // Construtor
    public function __construct(
        MovimentacaoRepositoryInterface $movimentacaoRepository,
        FornecedorRepositoryInterface $fornecedorRepository,
        MovimentacaoStrategyFactory $strategyFactory 
    ) {
        $this->movimentacaoRepository = $movimentacaoRepository;
        $this->fornecedorRepository = $fornecedorRepository;
        $this->strategyFactory = $strategyFactory;
    }

    public function listarMovimentacoes(): Collection
    {
        return $this->movimentacaoRepository->allWithLivroAndUser();
    }

    /**
     * Método para usar o padrão Strategy e Factory
     */
    public function criarMovimentacao(array $dados): Movimentacao
    {

        $dataParaCriar = $dados;

        if ($dados['tipo_relacionamento'] === 'fornecedor') {
            $fornecedor = $this->fornecedorRepository->find($dados['relacionamento_id']);
            if ($fornecedor) {
                $dataParaCriar['nome_contato'] = $fornecedor->razao_social;
                $dataParaCriar['telefone_contato'] = $fornecedor->telefone;
            }
        }

        $dataParaCriar['responsavel'] = Auth::user()->name;

        $strategy = $this->strategyFactory->make($dados['tipo']);

        return $strategy->executar($dataParaCriar);
    }

    /**
     * Regra de Negócio: Exclui uma movimentação e reverte o estoque.
     * (Este método permanece igual)
     */
    public function excluirMovimentacao(Movimentacao $movimentacao): bool
    {
        try {
            DB::beginTransaction();

            $movimentacao->reverterEstoque();
            $this->movimentacaoRepository->delete($movimentacao);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erro ao reverter movimentação: " . $e->getMessage());
            throw new Exception('Erro ao excluir e reverter movimentação: ' . $e->getMessage());
        }
    }
}