<?php

namespace App\Commands\Livro;

use App\Interfaces\Services\LivroServiceInterface;
use App\Models\Livro;

/**
 * Command Handler responsável por executar a exclusão do livro.
 * (Não precisa de um DTO, o próprio modelo é o "comando")
 */
class ExcluirLivroHandler
{
    private LivroServiceInterface $livroService;

    public function __construct(LivroServiceInterface $livroService)
    {
        $this->livroService = $livroService;
    }

    /**
     * @throws \Exception
     */
    public function handle(Livro $livro): bool
    {
        return $this->livroService->excluirLivro($livro);
    }
}