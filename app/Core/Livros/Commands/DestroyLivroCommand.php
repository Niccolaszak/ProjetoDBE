<?php
// app/Core/Livros/Commands/DestroyLivroCommand.php
namespace App\Core\Livros\Commands;

use App\Models\Livro;

/**
 * Este é o DTO (Command) que carrega os dados necessários
 * para DELETAR um livro.
 */
class DestroyLivroCommand
{
    /**
     * @param Livro $livro
     */
    public function __construct(
        public readonly Livro $livro
    ) {
    }
}