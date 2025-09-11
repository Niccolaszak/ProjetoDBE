<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GeneroController extends Controller
{
    public function index(): View
    {
        $generos = Genero::all();
        return view('generos.index', compact('generos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'genero' => 'required|string|max:100',
            'descricao_genero' => 'required|string',
        ]);

        Genero::create($request->only('genero','descricao_genero'));

        return redirect()->route('generos.index')->with('success', 'Gênero criado com sucesso!');
    }

    public function destroy(Genero $genero): RedirectResponse
    {
        
        if ($genero->livros()->exists()) {
            return redirect()->route('generos.index')->with('error', 'Não é possível excluir este gênero, pois existem livros vinculados a ele.');
        }

        $genero->delete();

        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso!');
    }
}