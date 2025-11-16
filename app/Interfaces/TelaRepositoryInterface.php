<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Telas.
 */
interface TelaRepositoryInterface
{
    /**
     * Retorna todas as telas.
     *
     * @return Collection
     */
    public function all(): Collection;
}