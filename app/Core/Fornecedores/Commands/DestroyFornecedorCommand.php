<?php

namespace App\Core\Fornecedores\Commands;

use App\Models\Fornecedor;

/**
 * Command (DTO) para transportar o modelo de Fornecedor
 * que deve ser excluído.
 */
class DestroyFornecedorCommand
{
    /**
     * @param Fornecedor $fornecedor
     */
    public function __construct(
        public readonly Fornecedor $fornecedor
    ) {
    }
}