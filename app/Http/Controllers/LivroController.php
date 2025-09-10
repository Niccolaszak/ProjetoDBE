<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LivroController extends Controller
{

    public function index(): View
    {
        $livros = Livro::with('genero')->get();
        return view('livros.index', compact('livros'));
    }

    public function create(): View
    {
        $generos = Genero::all();
        return view('livros.create', compact('generos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        Livro::create($request->only('titulo','autor','genero_id','descricao_livro'));

        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso!');
    }

    public function edit(Livro $livro): View
    {
        $generos = Genero::all();
        return view('livros.edit', compact('livro', 'generos'));
    }

    public function show(Livro $livro): View
    {
        // Carrega o gênero e movimentações relacionadas ao livro
        $livro->load(['genero', 'movimentacoes']);

        return view('livros.show', compact('livro'));
    }

    public function update(Request $request, Livro $livro): RedirectResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        $livro->update($request->only('titulo','autor','genero_id','descricao_livro'));

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Livro $livro): RedirectResponse
    {
        
        if ($livro->movimentacoes()->exists()) {
            return redirect()->route('livros.index')->with('error', 'Não é possível excluir este livro, pois existem movimentações vinculadas.');
        }

        $livro->delete();

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }
}