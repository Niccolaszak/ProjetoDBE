<?php

namespace App\Core\Setores\Handlers;

use App\Core\Setores\Commands\CreateSetorCommand;
use App\Models\Setor;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de criação de um novo Setor.
 */
class CreateSetorHandler
{
    /**
     * Executa o comando de criação.
     *
     * @param CreateSetorCommand $command
     * @return Setor
     */
    public function __invoke(CreateSetorCommand $command): Setor
    {

        $setor = Setor::create([
            'setor' => $command->setor,
        ]);

        return $setor;
    }
}