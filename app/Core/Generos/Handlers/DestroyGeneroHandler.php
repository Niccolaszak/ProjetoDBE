<?php

namespace App\Core\Generos\Handlers;

use App\Core\Generos\Commands\DestroyGeneroCommand;
use LogicException; // Para erros de regra de negócio

/**
 * Handler (CQRS) responsável por executar a lógica
 * de exclusão de um Gênero, aplicando regras de negócio.
 */
class DestroyGeneroHandler
{
    /**
     * Executa o comando de exclusão.
     *
     * @param DestroyGeneroCommand $command
     * @return void
     * @throws LogicException Se o gênero não puder ser excluído.
     */
    public function __invoke(DestroyGeneroCommand $command): void
    {
        $genero = $command->genero;

        // Regra de Negócio: Verifica se existem livros vinculados a este gênero antes de permitir a exclusão.
        if ($genero->livros()->exists()) {
            // Lança um erro de negócio que o Controller irá capturar
            throw new LogicException('Este gênero possui livros vinculados e não pode ser excluído.');
        }

        // Persistência: Exclui o gênero
        $genero->delete();
    }
}