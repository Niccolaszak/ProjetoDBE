<?php

namespace App\Commands\Livro;

use App\Interfaces\Services\LivroServiceInterface;
use App\Models\Livro;

/**
 * Command Handler responsável por executar a criação do livro.
 */
class CriarLivroHandler
{
    private LivroServiceInterface $livroService;

    public function __construct(LivroServiceInterface $livroService)
    {
        $this->livroService = $livroService;
    }

    public function handle(CriarLivroCommand $command): Livro
    {
        return $this->livroService->criarLivro($command->dados);
    }
}