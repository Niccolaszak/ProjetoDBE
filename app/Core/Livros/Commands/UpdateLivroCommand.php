<?php
// app/Core/Livros/Commands/UpdateLivroCommand.php
namespace App\Core\Livros\Commands;

use App\Models\Livro;

/**
 * Este é o DTO (Command) que carrega os dados necessários
 * para ATUALIZAR um livro existente.
 */
class UpdateLivroCommand
{
    public function __construct(
        public readonly Livro $livro,
        public readonly string $titulo,
        public readonly string $autor,
        public readonly int $genero_id,
        public readonly string $descricao_livro
    ) {
    }
}