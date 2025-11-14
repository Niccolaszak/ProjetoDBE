<?php

namespace App\Core\Fornecedores\Handlers;

use App\Core\Fornecedores\Commands\DestroyFornecedorCommand;
use LogicException; // Para erros de regra de negócio

/**
 * Handler (CQRS) responsável por executar a lógica
 * de exclusão de um Fornecedor, aplicando regras de negócio.
 */
class DestroyFornecedorHandler
{
    /**
     * Executa o comando de exclusão.
     *
     * @param DestroyFornecedorCommand $command
     * @return void
     * @throws LogicException Se o fornecedor não puder ser excluído.
     */
    public function __invoke(DestroyFornecedorCommand $command): void
    {
        $fornecedor = $command->fornecedor;

        // Regra de Negócio: Verifica se existem movimentações vinculadas a este fornecedor antes de permitir a exclusão.
        if ($fornecedor->movimentacoes()->exists()) {
            // Lança um erro de negócio que o Controller irá capturar
            throw new LogicException('Este fornecedor possui movimentações vinculadas e não pode ser excluído.');
        }

        // Persistência: Exclui o fornecedor
        $fornecedor->delete();
    }
}