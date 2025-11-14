<?php

namespace App\Core\Cargos\Commands;

use App\Models\Cargo;

/**
 * Command (DTO) para transportar os dados necessários
 * para a exclusão de um Cargo.
 */
class DestroyCargoCommand
{
    /**
     * @param Cargo $cargo
     */
    public function __construct(
        public readonly Cargo $cargo
    ) {
    }
}