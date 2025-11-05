<?php
// app/Core/Livros/Commands/CreateLivroCommand.php
namespace App\Core\Livros\Commands;

/**
 * Este é o DTO (Command) que carrega os dados necessários
 * para criar um novo livro.
 */
class CreateLivroCommand
{
    public function __construct(
        public readonly string $titulo,
        public readonly string $autor,
        public readonly int $genero_id,
        public readonly string $descricao_livro
    ) {
    }
}