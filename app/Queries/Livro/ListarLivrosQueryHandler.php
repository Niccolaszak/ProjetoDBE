<?php

namespace App\Queries\Livro;

use App\Interfaces\LivroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Query Handler responsável EXCLUSIVAMENTE por
 * buscar a lista de livros para a view.
 */
class ListarLivrosQueryHandler
{
    private LivroRepositoryInterface $livroRepository;

    public function __construct(LivroRepositoryInterface $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    /**
     * Executa a consulta.
     */
    public function handle(): Collection
    {
        return $this->livroRepository->allWithGenero();
    }
}