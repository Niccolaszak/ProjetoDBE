<?php

namespace App\Core\Permissoes\Commands;

/**
 * Command (DTO) para transportar o ID do cargo
 * que terá suas permissões removidas (desanexadas).
 */
class RemoverPermissoesCargoCommand
{
    /**
     * @param int $cargoId
     */
    public function __construct(
        public readonly int $cargoId
    ) {
    }
}