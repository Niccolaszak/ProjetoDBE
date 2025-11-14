<?php

namespace App\Http\Controllers;

use App\Models\Genero; // Route-Model-Binding
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LogicException; // Para capturar erros de negócio
use App\Core\Generos\Queries\ListarGenerosQuery;
use App\Core\Generos\Commands\CreateGeneroCommand;
use App\Core\Generos\Handlers\CreateGeneroHandler;
use App\Core\Generos\Commands\DestroyGeneroCommand;
use App\Core\Generos\Handlers\DestroyGeneroHandler;

/**
 * Controller para o CRUD de Gêneros.
 */
class GeneroController extends Controller
{
    /**
     * Exibe a lista de gêneros.
     *
     * @param ListarGenerosQuery $query
     * @return View
     */
    public function index(ListarGenerosQuery $query): View
    {
        // Delega a busca de dados para a classe Query
        $data = $query->handle();

        return view('generos.index', $data);
    }

    /**
     * Valida e armazena um novo gênero.
     *
     * @param Request $request
     * @param CreateGeneroHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, CreateGeneroHandler $handler): RedirectResponse
    {
        $validated = $request->validate([
            'genero' => 'required|string|max:100|unique:generos,genero',
        ]);

        // Cria o DTO para transportar os dados
        $command = new CreateGeneroCommand(
            genero: $validated['genero']
        );

        // O Handler executa a criação
        $handler($command);

        return redirect()->route('generos.index')->with('success', 'Gênero criado com sucesso!');
    }

    /**
     * Remove um gênero existente.
     *
     * @param Genero $genero (Injetado pela Rota-Model-Binding)
     * @param DestroyGeneroHandler $handler
     * @return RedirectResponse
     */
    public function destroy(Genero $genero, DestroyGeneroHandler $handler): RedirectResponse
    {
        try {
            // O Command transporta o modelo a ser excluído
            $command = new DestroyGeneroCommand(genero: $genero);
            
            // O Handler executa a verificação e a exclusão
            $handler($command);

        } catch (LogicException $e) {
            // Captura o erro de negócio (ex: "Gênero possui livros")
            return redirect()->route('generos.index')->with('error', $e->getMessage());
        }

        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso!');
    }
}