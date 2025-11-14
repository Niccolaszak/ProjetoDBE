<?php

namespace App\Core\Fornecedores\Commands;

/**
 * Command (DTO) para transportar os dados validados
 * para a criação de um novo Fornecedor.
 */
class CreateFornecedorCommand
{
    /**
     * @param string $razao_social
     * @param string $nome_fantasia
     * @param string $cnpj
     * @param string $telefone
     * @param string $email
     * @param string $cep
     */
    public function __construct(
        public readonly string $razao_social,
        public readonly string $nome_fantasia,
        public readonly string $cnpj,
        public readonly string $telefone,
        public readonly string $email,
        public readonly string $cep
    ) {
    }
}