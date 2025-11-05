<?php

namespace App\Http\Controllers;

// Imports do CQRS
use App\Core\Livros\Commands\CreateLivroCommand;
use App\Core\Livros\Handlers\CreateLivroHandler;
use App\Core\Livros\Commands\UpdateLivroCommand;
use App\Core\Livros\Handlers\UpdateLivroHandler;
use App\Core\Livros\Commands\DestroyLivroCommand;
use App\Core\Livros\Handlers\DestroyLivroHandler;
use App\Core\Livros\Queries\ListarLivrosQuery; 

// Imports de Models e Request
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LivroController extends Controller
{
    /**
     * @param ListarLivrosQuery $query
     * @return View
     */
    public function index(ListarLivrosQuery $query): View
    {
        $data = $query->handle();

        return view('livros.index', $data);
    }

    /**
     * @param Request $request
     * @param CreateLivroHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, CreateLivroHandler $handler): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        $command = new CreateLivroCommand(
            titulo: $validated['titulo'],
            autor: $validated['autor'],
            genero_id: (int) $validated['genero_id'],
            descricao_livro: $validated['descricao_livro']
        );

        $handler($command);

        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * @param Request $request
     * @param Livro $livro
     * @param UpdateLivroHandler $handler
     * @return RedirectResponse
     */
    public function update(Request $request, Livro $livro, UpdateLivroHandler $handler): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        $command = new UpdateLivroCommand(
            livro: $livro,
            titulo: $validated['titulo'],
            autor: $validated['autor'],
            genero_id: (int) $validated['genero_id'],
            descricao_livro: $validated['descricao_livro']
        );

        $handler($command);

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * @param Livro $livro
     * @param DestroyLivroHandler $handler
     * @return RedirectResponse
     */
    public function destroy(Livro $livro, DestroyLivroHandler $handler): RedirectResponse
    {
        $command = new DestroyLivroCommand(livro: $livro);

        try {
            $handler($command);
        } catch (\Exception $e) {
            return redirect()->route('livros.index')->with('error', $e->getMessage());
        }

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }
}