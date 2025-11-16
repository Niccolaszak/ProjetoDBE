<?php

namespace App\Repositories;

use App\Interfaces\GeneroRepositoryInterface;
use App\Models\Genero;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do GeneroRepositoryInterface.
 */
class EloquentGeneroRepository implements GeneroRepositoryInterface
{
    /**
     * Retorna todos os gêneros.
     */
    public function all(): Collection
    {
        return Genero::all();
    }

    /**
     * Cria um novo gênero.
     */
    public function create(array $data): Genero
    {
        return Genero::create($data);
    }

    /**
     * Exclui um gênero.
     */
    public function delete(Genero $genero): ?bool
    {
        return $genero->delete();
    }

    /**
     * Verifica se um gênero possui livros associados.
     */
    public function hasLivros(Genero $genero): bool
    {
        return $genero->livros()->exists();
    }
}