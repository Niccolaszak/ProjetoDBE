<?php

namespace App\Core\Cargos\Commands;

/**
 * Command (DTO) para transportar os dados validados
 * para a criação de um novo Cargo.
 */
class CreateCargoCommand
{
    /**
     * @param string $cargo
     * @param float $salario
     */
    public function __construct(
        public readonly string $cargo,
        public readonly float $salario
    ) {
    }
}