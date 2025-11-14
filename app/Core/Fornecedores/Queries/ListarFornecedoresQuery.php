<?php

namespace App\Core\Fornecedores\Queries;

use App\Models\Fornecedor;

/**
 * Classe Query (CQRS) responsável por buscar os dados
 * necessários para a tela de gerenciamento de Fornecedores.
 */
class ListarFornecedoresQuery
{
    /**
     * Executa a busca de todos os fornecedores.
     *
     * @return array
     */
    public function handle(): array
    {
        // Otimização: Carrega a contagem de movimentações
        // para evitar N+1 queries na view (SRP).
        $fornecedores = Fornecedor::withCount('movimentacoes')->get();

        return compact('fornecedores');
    }
}