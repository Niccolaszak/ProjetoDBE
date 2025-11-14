<?php

namespace App\Core\Generos\Commands;

use App\Models\Genero;

/**
 * Command (DTO) para transportar o modelo de Gênero
 * que deve ser excluído.
 */
class DestroyGeneroCommand
{
    /**
     * @param Genero $gener
     */
    public function __construct(
        public readonly Genero $genero
    ) {
    }
}