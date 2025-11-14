<?php

namespace App\Core\Setores\Queries;

use App\Models\Setor;

/**
 * Classe Query (CQRS) responsável por buscar os dados
 * necessários para a tela de gerenciamento de Setores.
 */
class ListarSetoresQuery
{
    /**
     * Executa a busca de todos os setores.
     *
     * @return array
     */
    public function handle(): array
    {
        // Carrega todos os setores e já otimiza a contagem de usuários (withCount) para evitar N+1 queries na view.
        $setores = Setor::withCount('users')->get();

        // Retorna os dados prontos para a view
        return compact('setores');
    }
}