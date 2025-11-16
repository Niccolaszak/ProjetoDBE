<?php

namespace App\Repositories;

use App\Interfaces\TelaRepositoryInterface;
use App\Models\Tela;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do TelaRepositoryInterface.
 */
class EloquentTelaRepository implements TelaRepositoryInterface
{
    /**
     * Retorna todas as telas.
     */
    public function all(): Collection
    {
        return Tela::all();
    }
}