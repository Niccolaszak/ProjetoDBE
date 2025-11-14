<?php

namespace App\Core\Cargos\Queries;

use App\Models\Cargo;

/**
 * Classe Query (CQRS) responsável por buscar os dados
 * necessários para a tela de gerenciamento de Cargos.
 */
class ListarCargosQuery
{
    /**
     * Executa a busca de todos os cargos.
     *
     * @return array
     */
    public function handle(): array
    {
        // Otimização: Carrega 'users' para contagem, se necessário, ou apenas lista os cargos.
        $cargos = Cargo::withCount('users')->get();

        // Retorna os dados prontos para a view
        return compact('cargos');
    }
}