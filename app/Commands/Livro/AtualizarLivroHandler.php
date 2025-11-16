<?php

namespace App\Commands\Livro;

use App\Interfaces\Services\LivroServiceInterface;

/**
 * Command Handler responsável por executar a atualização do livro.
 */
class AtualizarLivroHandler
{
    private LivroServiceInterface $livroService;

    public function __construct(LivroServiceInterface $livroService)
    {
        $this->livroService = $livroService;
    }

    public function handle(AtualizarLivroCommand $command): bool
    {
        return $this->livroService->atualizarLivro($command->livro, $command->dados);
    }
}