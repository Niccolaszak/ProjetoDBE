<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LivroController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Livro::class, 'livro');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        
        $livros  = Livro::with('genero')->get();
        $generos = Genero::all();
        $generosOptions = $generos->map(fn($g) => (object)[
            'id' => $g->id,
            'nome' => $g->genero
        ]);               

        return view('livros.index', compact('livros', 'generosOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        // Proteção contra Mass Assignment
        Livro::create($validatedData);

        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livro $livro): RedirectResponse
    {
        
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        // Proteção contra Mass Assignment
        $livro->update($validatedData);

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livro $livro): RedirectResponse
    {
        
        // Esta lógica de negócio será movida para um Service na Fase 2,
        // mas por enquanto, ela permanece aqui.
        if ($livro->movimentacoes()->exists()) {
            return redirect()->route('livros.index')->with('error', 'Não é possível excluir este livro, pois existem movimentações vinculadas.');
        }

        $livro->delete();

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }
}