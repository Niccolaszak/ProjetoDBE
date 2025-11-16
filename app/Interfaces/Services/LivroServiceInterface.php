<?php

namespace App\Interfaces\Services;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o serviço de Livros.
 */
interface LivroServiceInterface
{
    public function listarLivros(): Collection;
    public function criarLivro(array $dados): Livro;
    public function atualizarLivro(Livro $livro, array $dados): bool;
    public function excluirLivro(Livro $livro): bool;
}