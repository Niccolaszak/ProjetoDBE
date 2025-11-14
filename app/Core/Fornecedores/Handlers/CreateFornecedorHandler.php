<?php

namespace App\Core\Fornecedores\Handlers;

use App\Core\Fornecedores\Commands\CreateFornecedorCommand;
use App\Models\Fornecedor;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de criação de um novo Fornecedor.
 */
class CreateFornecedorHandler
{
    /**
     * Executa o comando de criação.
     *
     * @param CreateFornecedorCommand $command
     * @return Fornecedor
     */
    public function __invoke(CreateFornecedorCommand $command): Fornecedor
    {
        // Lógica de persistência
        $fornecedor = Fornecedor::create([
            'razao_social' => $command->razao_social,
            'nome_fantasia' => $command->nome_fantasia,
            'cnpj' => $command->cnpj,
            'telefone' => $command->telefone,
            'email' => $command->email,
            'cep' => $command->cep,
        ]);

        return $fornecedor;
    }
}