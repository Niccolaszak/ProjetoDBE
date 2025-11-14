<?php

namespace App\Core\Cargos\Handlers;

use App\Core\Cargos\Commands\CreateCargoCommand;
use App\Models\Cargo;

/**
 * Handler (CQRS) responsável por executar a lógica
 * de criação de um novo Cargo.
 */
class CreateCargoHandler
{
    /**
     * Executa o comando de criação.
     *
     * @param CreateCargoCommand $command
     * @return Cargo
     */
    public function __invoke(CreateCargoCommand $command): Cargo
    {

        $cargo = Cargo::create([
            'cargo' => $command->cargo,
            'salario' => $command->salario,
        ]);

        return $cargo;
    }
}