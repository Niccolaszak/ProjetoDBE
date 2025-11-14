<?php

namespace App\Core\Permissoes\Queries;

use App\Models\Cargo;
use App\Models\Tela;

/**
 * Classe Query (CQRS) responsável por buscar os dados
 * necessários para a tela de gerenciamento de permissões.
 */
class ListarPermissoesQuery
{
    /**
     * Executa a busca de cargos (com suas permissões) e todas as telas.
     *
     * @return array
     */
    public function handle(): array
    {
        // Otimização: Carrega 'permissoes' para evitar N+1 queries na view
        $cargos = Cargo::with('permissoes')->get();
        $telas = Tela::all();

        // Retorna os dados prontos para a view
        return compact('cargos', 'telas');
    }
}