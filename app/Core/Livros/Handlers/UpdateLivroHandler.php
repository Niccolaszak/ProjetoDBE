<?php
// app/Core/Livros/Handlers/UpdateLivroHandler.php
namespace App\Core\Livros\Handlers;

use App\Core\Livros\Commands\UpdateLivroCommand;
use App\Models\Livro;

class UpdateLivroHandler
{
    /**
     * O método __invoke torna a classe "callable".
     *
     * @param UpdateLivroCommand $command
     * @return Livro
     */
    public function __invoke(UpdateLivroCommand $command): Livro
    {

        $livro = $command->livro;

        $livro->update([
            'titulo' => $command->titulo,
            'autor' => $command->autor,
            'genero_id' => $command->genero_id,
            'descricao_livro' => $command->descricao_livro,
        ]);

        return $livro;
    }
}