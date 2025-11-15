<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Movimentacao;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Totais globais
        $estoque = (object)[
            'quantidade_disponivel' => Estoque::sum('quantidade_disponivel'),
            'quantidade_consumida'  => Estoque::sum('quantidade_consumida'),
        ];

        $totalMovimentacoes = Movimentacao::count();
        $totalLivros = Estoque::count(); // cada estoque está ligado a um livro

        // Movimentações mensais (agrupadas por mês)
        $movimentacoes = Movimentacao::selectRaw("
            DATE_FORMAT(created_at, '%m/%Y') as mes,
            SUM(CASE WHEN tipo='entrada' THEN quantidade ELSE 0 END) as entradas,
            SUM(CASE WHEN tipo='saida' THEN quantidade ELSE 0 END) as saidas
        ")->groupBy('mes')->orderBy('mes')->get();

        $movimentacoesLabels = $movimentacoes->pluck('mes');
        $movimentacoesEntradas = $movimentacoes->pluck('entradas');
        $movimentacoesSaidas = $movimentacoes->pluck('saidas');


        $estoques = Estoque::with('livro')->get();
        $livrosLabels = $estoques->pluck('livro.titulo');
        $livrosDisponiveis = $estoques->pluck('quantidade_disponivel');

        return view('dashboard.index', compact(
            'estoque',
            'totalMovimentacoes',
            'totalLivros',
            'movimentacoesLabels',
            'movimentacoesEntradas',
            'movimentacoesSaidas',
            'livrosLabels',
            'livrosDisponiveis'
        ));
    }
}