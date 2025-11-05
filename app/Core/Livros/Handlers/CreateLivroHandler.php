<?php
// app/Core/Livros/Handlers/CreateLivroHandler.php
namespace App\Core\Livros\Handlers;

use App\Core\Livros\Commands\CreateLivroCommand;
use App\Models\Livro;
use Illuminate\Support\Facades\Hash; // Embora não usado aqui, é comum em Handlers

class CreateLivroHandler
{
    /**
     * O método __invoke torna a classe "callable".
     *
     * @param CreateLivroCommand $command
     * @return Livro
     */
    public function __invoke(CreateLivroCommand $command): Livro
    {
        // 1. A lógica de negócio / persistência

        $livro = Livro::create([
            'titulo' => $command->titulo,
            'autor' => $command->autor,
            'genero_id' => $command->genero_id,
            'descricao_livro' => $command->descricao_livro,
        ]);

        // 3. Retorna o modelo criado
        return $livro;
    }
}