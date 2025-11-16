<?php

namespace App\Commands\Livro;

/**
 * DTO (Command) para carregar os dados de criação de um livro.
 */
class CriarLivroCommand
{
    public array $dados;

    public function __construct(array $dadosValidados)
    {
        $this->dados = $dadosValidados;
    }
}