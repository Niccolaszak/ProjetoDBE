<?php

namespace App\Interfaces;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Gêneros.
 */
interface GeneroRepositoryInterface
{
    /**
     * Retorna todos os gêneros.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Cria um novo gênero.
     *
     * @param array $data
     * @return Genero
     */
    public function create(array $data): Genero;

    /**
     * Exclui um gênero.
     *
     * @param Genero $genero
     * @return bool|null
     */
    public function delete(Genero $genero): ?bool;

    /**
     * Verifica se um gênero possui livros associados.
     *
     * @param Genero $genero
     * @return bool
     */
    public function hasLivros(Genero $genero): bool;
}