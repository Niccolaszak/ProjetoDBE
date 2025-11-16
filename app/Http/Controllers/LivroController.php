<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Interfaces\GeneroRepositoryInterface;
use Exception;

// Imports do CQRS
use App\Queries\Livro\ListarLivrosQueryHandler;
use App\Commands\Livro\CriarLivroCommand;
use App\Commands\Livro\CriarLivroHandler;
use App\Commands\Livro\AtualizarLivroCommand;
use App\Commands\Livro\AtualizarLivroHandler;
use App\Commands\Livro\ExcluirLivroHandler;

class LivroController extends Controller
{    
    // Handlers Injetados
    private ListarLivrosQueryHandler $listarLivrosHandler;
    private CriarLivroHandler $criarLivroHandler;
    private AtualizarLivroHandler $atualizarLivroHandler;
    private ExcluirLivroHandler $excluirLivroHandler;

    private GeneroRepositoryInterface $generoRepository;

    public function __construct(
        ListarLivrosQueryHandler $listarLivrosHandler,
        CriarLivroHandler $criarLivroHandler,
        AtualizarLivroHandler $atualizarLivroHandler,
        ExcluirLivroHandler $excluirLivroHandler,
        
        GeneroRepositoryInterface $generoRepository
    ) {
        $this->listarLivrosHandler = $listarLivrosHandler;
        $this->criarLivroHandler = $criarLivroHandler;
        $this->atualizarLivroHandler = $atualizarLivroHandler;
        $this->excluirLivroHandler = $excluirLivroHandler;
        
        $this->generoRepository = $generoRepository;

        $this->authorizeResource(Livro::class, 'livro');
    }

    /**
     * Lado da QUERY: Chama o handler de listagem.
     */
    public function index(): View
    {
        $livros  = $this->listarLivrosHandler->handle();
        
        $generos = $this->generoRepository->all();
        $generosOptions = $generos->map(fn($g) => (object)[
            'id' => $g->id,
            'nome' => $g->genero
        ]);               

        return view('livros.index', compact('livros', 'generosOptions'));
    }

    /**
     * Lado do COMMAND: Chama o handler de criação.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        $command = new CriarLivroCommand($validatedData);

        $this->criarLivroHandler->handle($command);

        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * Lado do COMMAND: Chama o handler de atualização.
     */
    public function update(Request $request, Livro $livro): RedirectResponse
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:100',
            'autor' => 'required|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'descricao_livro' => 'required|string',
        ]);

        $command = new AtualizarLivroCommand($livro, $validatedData);

        $this->atualizarLivroHandler->handle($command);

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Lado do COMMAND: Chama o handler de exclusão.
     */
    public function destroy(Livro $livro): RedirectResponse
    {
        try {
            $this->excluirLivroHandler->handle($livro);
            
            return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
        
        } catch (Exception $e) {
            return redirect()->route('livros.index')->with('error', $e->getMessage());
        }
    }
}