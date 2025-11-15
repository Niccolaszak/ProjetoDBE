<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GeneroController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Genero::class, 'genero');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        
        $generos = Genero::all();
        $generosOptions = $generos->map(fn($g) => (object)[
            'id' => $g->id,
            'nome' => $g->genero
        ]);

        return view('generos.index', compact('generos', 'generosOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'genero' => 'required|string|max:100|unique:generos',
            'descricao_genero' => 'required|string',
        ]);

        Genero::create($request->only('genero','descricao_genero'));

        return redirect()->route('generos.index')->with('success', 'Gênero criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero): RedirectResponse
    {

        if ($genero->livros()->exists()) {
            return redirect()->route('generos.index')->with('error', 'Não é possível excluir este gênero, pois existem livros vinculados.');
        }

        $genero->delete();

        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso!');
    }
}