<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\Livro;
use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MovimentacaoController extends Controller
{
    public function index(): View
    {
        $movimentacoes = Movimentacao::with('livro')->get();
        $livros = Livro::all();
        $livrosOptions = $livros->map(fn($livro) => (object)[
            'id' => $livro->id,
            'nome' => $livro->titulo
        ]);
        $fornecedores = Fornecedor::all();
        $fornecedoresOptions = $fornecedores->map(fn($f) => (object)[
            'id' => $f->id,
            'nome' => $f->razao_social,
        ]);
        $users = User::all();

        return view('movimentacoes.index', compact('movimentacoes', 'livros', 'livrosOptions', 'fornecedores', 'fornecedoresOptions', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'quantidade' => 'required|integer|min:1',
            'tipo' => 'required|in:entrada,saida',
            'tipo_relacionamento' => 'required|in:fornecedor,cliente',
            'relacionamento_id' => 'nullable|exists:fornecedores,id',
            'nome_contato' => $request->tipo_relacionamento === 'cliente' ? 'required|string|max:150' : 'nullable|string|max:150',
            'telefone_contato' => $request->tipo_relacionamento === 'cliente' ? 'required|string|max:20' : 'nullable|string|max:20',
            'observacao' => 'nullable|string',
        ]);

        $livro = Livro::findOrFail($request->livro_id);
        $estoque = $livro->estoque;

        // Bloqueia saída se estoque insuficiente
        if ($request->tipo === 'saida') {
            $quantidade = $request->quantidade;
            if (!$estoque || $estoque->quantidade_disponivel < $quantidade) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Não é possível registrar saída. Estoque insuficiente!');
            }
        }

        $data = $request->all();

        if ($request->tipo_relacionamento === 'fornecedor' && $request->relacionamento_id) {
            $fornecedor = Fornecedor::find($request->relacionamento_id);
            $data['nome_contato'] = $fornecedor->razao_social;
            $data['telefone_contato'] = $fornecedor->telefone;
        }

        // Se for cliente, nome_contato e telefone_contato já vêm do form
        Movimentacao::create($data);

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação registrada com sucesso!');
    }

    public function destroy($id)
    {
        $movimentacao = Movimentacao::findOrFail($id);
        try {
            $movimentacao->reverterEstoque();

            $movimentacao->delete();

            return redirect()->route('movimentacoes.index')->with('success', 'Movimentação excluída com sucesso!');
        } catch (\Exception $e) {
            // Retorna erro amigável para o Blade
            return redirect()->route('movimentacoes.index')->with('error', $e->getMessage());
        }
    }
}