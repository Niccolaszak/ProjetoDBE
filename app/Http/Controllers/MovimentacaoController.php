<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MovimentacaoController extends Controller
{
    public function index(): View
    {
        $movimentacoes = Movimentacao::with('livro')->get();
        $livros = Livro::all();
        return view('movimentacoes.index', compact('movimentacoes', 'livros'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'quantidade' => 'required|integer|min:1',
            'tipo' => 'required|in:entrada,saida',
            'responsavel' => 'required|string|max:100',
            'observacao' => 'nullable|string',
        ]);

        Movimentacao::create($request->all());

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação registrada com sucesso!');
    }

    public function destroy(Movimentacao $movimentacao): RedirectResponse
    {
    
        $movimentacao->delete();

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação excluída com sucesso!');
    }
}