<?php

namespace App\Core\Dashboard\Queries;

use App\Models\Estoque;
use App\Models\Movimentacao;

/**
 * Classe Query (CQRS) responsável por centralizar
 * toda a lógica de busca de dados para o Dashboard.
 */
class GetDashboardDataQuery
{
    /**
     * Executa todas as consultas necessárias e formata os dados
     * para a view do dashboard.
     *
     * @return array
     */
    public function handle(): array
    {
        // Cards de Totais
        $estoque = (object)[
            'quantidade_disponivel' => Estoque::sum('quantidade_disponivel'),
            'quantidade_consumida'  => Estoque::sum('quantidade_consumida'),
        ];
        $totalMovimentacoes = Movimentacao::count();
        $totalLivros = Estoque::count();

        // Gráfico de Linha: Movimentações Mensais
        $movimentacoes = Movimentacao::selectRaw("
            DATE_FORMAT(created_at, '%m/%Y') as mes,
            SUM(CASE WHEN tipo='entrada' THEN quantidade ELSE 0 END) as entradas,
            SUM(CASE WHEN tipo='saida' THEN quantidade ELSE 0 END) as saidas
        ")
        ->groupBy('mes')
        // Garante a ordem cronológica correta em vez de alfabética
        ->orderByRaw("MIN(created_at)")
        ->get();

        $movimentacoesLabels = $movimentacoes->pluck('mes');
        $movimentacoesEntradas = $movimentacoes->pluck('entradas');
        $movimentacoesSaidas = $movimentacoes->pluck('saidas');

        // Gráfico de Barras: Estoque por Livro
        // Otimização: Seleciona apenas as colunas necessárias
        $estoques = Estoque::with('livro:id,titulo')
                        ->select('livro_id', 'quantidade_disponivel')
                        ->get();

        $livrosLabels = $estoques->pluck('livro.titulo');
        $livrosDisponiveis = $estoques->pluck('quantidade_disponivel');

        // Retorna um array associativo pronto para a view
        return compact(
            'estoque',
            'totalMovimentacoes',
            'totalLivros',
            'movimentacoesLabels',
            'movimentacoesEntradas',
            'movimentacoesSaidas',
            'livrosLabels',
            'livrosDisponiveis'
        );
    }
}