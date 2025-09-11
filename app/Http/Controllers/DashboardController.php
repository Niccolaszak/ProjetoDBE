<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Movimentacao;

class DashboardController extends Controller
{
    public function index()
    {
        // Pega o estoque atual (ajuste conforme sua lógica)
        $estoque = Estoque::with('livro')->first();

        // Agrupa movimentações por mês e tipo (entrada/saida)
        $movimentacoes = Movimentacao::selectRaw('DATE_FORMAT(data_hora, "%Y-%m") as mes, tipo, SUM(quantidade) as total')
            ->groupBy('mes', 'tipo')
            ->get();

        $labels = $movimentacoes->pluck('mes')->unique();
        $entradas = $labels->map(fn($mes) => $movimentacoes->where('mes', $mes)->where('tipo','entrada')->sum('total'));
        $saidas = $labels->map(fn($mes) => $movimentacoes->where('mes', $mes)->where('tipo','saida')->sum('total'));

        return view('dashboard.index', [
            'estoque' => $estoque,
            'movimentacoesLabels' => $labels,
            'movimentacoesEntradas' => $entradas,
            'movimentacoesSaidas' => $saidas,
        ]);
    }
}