<?php

namespace App\Core\Generos\Handlers;

use App\Core\Generos\Commands\CreateGeneroCommand;
use App\Models\Genero;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de criação de um novo Gênero.
 */
class CreateGeneroHandler
{
    /**
     * Executa o comando de criação.
     *
     * @param CreateGeneroCommand $command
     * @return Genero
     */
    public function __invoke(CreateGeneroCommand $command): Genero
    {
        // Lógica de persistência
        $genero = Genero::create([
            'genero' => $command->genero,
        ]);

        return $genero;
    }
}