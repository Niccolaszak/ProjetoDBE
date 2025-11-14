<?php

namespace App\Core\Setores\Commands;

use App\Models\Setor;

/**
 * Command (DTO) para transportar o modelo de Setor
 * que deve ser excluído.
 */
class DestroySetorCommand
{
    /**
     * @param Setor $setor
     */
    public function __construct(
        public readonly Setor $setor
    ) {
    }
}