<?php

namespace App\Core\Setores\Commands;

/**
 * Command (DTO) para transportar os dados validados
 * para a criação de um novo Setor.
 */
class CreateSetorCommand
{
    /**
     * @param string $setor
     */
    public function __construct(
        public readonly string $setor
    ) {
    }
}