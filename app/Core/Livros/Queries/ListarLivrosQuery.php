<?php
// app/Core/Livros/Queries/ListarLivrosQuery.php
namespace App\Core\Livros\Queries;

use App\Models\Genero;
use App\Models\Livro;

class ListarLivrosQuery
{
    /**
     * Este método é responsável por buscar todos os dados
     * necessários para a tela de listagem de livros.
     *
     * @return array
     */
    public function handle(): array
    {
        $livros  = Livro::with('genero')->get();
        $generos = Genero::all();

        $generosOptions = $generos->map(fn($g) => (object)[
            'id' => $g->id,
            'nome' => $g->genero
        ]);

        return [
            'livros' => $livros,
            'generosOptions' => $generosOptions,
        ];
    }
}