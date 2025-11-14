<?php

namespace App\Core\Generos\Queries;

use App\Models\Genero;

/**
 * Classe Query (CQRS) responsável por buscar os dados
 * necessários para a tela de gerenciamento de Gêneros.
 */
class ListarGenerosQuery
{
    /**
     * Executa a busca de todos os gêneros.
     *
     * @return array
     */
    public function handle(): array
    {
        // Otimização: Carrega a contagem de livros
        // para evitar N+1 queries na view (SRP).
        $generos = Genero::withCount('livros')->get();

        return compact('generos');
    }
}