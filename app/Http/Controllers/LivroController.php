<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Interfaces\LivroRepositoryInterface;
use App\Interfaces\GeneroRepositoryInterface;

class LivroController extends Controller
{
    private LivroRepositoryInterface $livroRepository;
    private GeneroRepositoryInterface $generoRepository;

    public function __construct(
        LivroRepositoryInterface $livroRepository,
        GeneroRepositoryInterface $generoRepository
    ) {
        $this->livroRepository = $livroRepository;
        $this->generoRepository = $generoRepository;

        $this->authorizeResource(Livro::class, 'livro');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $livros  = $this->livroRepository->allWithGenero();
        $generos = $this->generoRepository->all();
        
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

         $this->livroRepository->create($validatedData);

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

        $this->livroRepository->update($livro, $validatedData);

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livro $livro): RedirectResponse
    {
         if ($this->livroRepository->hasMovimentacoes($livro)) {
            return redirect()->route('livros.index')->with('error', 'Não é possível excluir este livro, pois existem movimentações vinculadas.');
        }

        $this->livroRepository->delete($livro);

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }
}