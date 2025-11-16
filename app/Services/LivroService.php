<?php

namespace App\Services;

use App\Interfaces\Services\LivroServiceInterface;
use App\Interfaces\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Exception;

class LivroService implements LivroServiceInterface
{
    private LivroRepositoryInterface $livroRepository;

    public function __construct(LivroRepositoryInterface $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function listarLivros(): Collection
    {
        return $this->livroRepository->allWithGenero();
    }

    public function criarLivro(array $dados): Livro
    {
        return $this->livroRepository->create($dados);
    }

    public function atualizarLivro(Livro $livro, array $dados): bool
    {
        return $this->livroRepository->update($livro, $dados);
    }

    /**
     * Regra de Negócio: Não permite excluir um livro se houver
     * movimentações associadas a ele.
     */
    public function excluirLivro(Livro $livro): bool
    {
        if ($this->livroRepository->hasMovimentacoes($livro)) {
            throw new Exception('Não é possível excluir este livro, pois existem movimentações vinculadas.');
        }

        return $this->livroRepository->delete($livro);
    }
}