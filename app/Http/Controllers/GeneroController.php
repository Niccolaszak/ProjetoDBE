<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Interfaces\GeneroRepositoryInterface;

class GeneroController extends Controller
{
    private GeneroRepositoryInterface $generoRepository;

    public function __construct(GeneroRepositoryInterface $generoRepository)
    {
        $this->generoRepository = $generoRepository;
        $this->authorizeResource(Genero::class, 'genero');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $generos = $this->generoRepository->all();
        
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

        $validatedData = $request->validate([
            'genero' => 'required|string|max:100|unique:generos',
            'descricao_genero' => 'required|string',
        ]);

        $this->generoRepository->create($validatedData);

        return redirect()->route('generos.index')->with('success', 'Gênero criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero): RedirectResponse
    {

        if ($this->generoRepository->hasLivros($genero)) {
            return redirect()->route('generos.index')->with('error', 'Não é possível excluir este gênero, pois existem livros vinculados.');
        }

        $this->generoRepository->delete($genero);

        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso!');
    }
}