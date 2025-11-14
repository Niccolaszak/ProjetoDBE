<?php

namespace App\Core\Generos\Commands;

/**
 * Command (DTO) para transportar os dados validados
 * para a criação de um novo Gênero.
 */
class CreateGeneroCommand
{
    /**
     * @param string $genero
     */
    public function __construct(
        public readonly string $genero
    ) {
    }
}