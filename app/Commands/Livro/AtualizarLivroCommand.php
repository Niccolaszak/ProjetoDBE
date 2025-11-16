<?php

namespace App\Commands\Livro;

use App\Models\Livro;

/**
 * DTO (Command) para carregar os dados de atualização de um livro.
 */
class AtualizarLivroCommand
{
    public Livro $livro;
    public array $dados;

    public function __construct(Livro $livro, array $dadosValidados)
    {
        $this->livro = $livro;
        $this->dados = $dadosValidados;
    }
}