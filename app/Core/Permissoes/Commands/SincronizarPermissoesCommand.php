<?php

namespace App\Core\Permissoes\Commands;

/**
 * Command (DTO) para transportar os dados necessários
 * para sincronizar as permissões de um cargo.
 */
class SincronizarPermissoesCommand
{
    /**
     * @param int $cargoId
     * @param array $telas
     */
    public function __construct(
        public readonly int $cargoId,
        public readonly array $telas
    ) {
    }
}