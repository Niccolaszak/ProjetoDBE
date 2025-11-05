<?php
// app/Core/Livros/Handlers/DestroyLivroHandler.php
namespace App\Core\Livros\Handlers;

use App\Core\Livros\Commands\DestroyLivroCommand;

class DestroyLivroHandler
{
    /**
     * O método __invoke torna a classe "callable".
     *
     * @param DestroyLivroCommand $command
     * @return void
     * @throws \Exception 
     */
    public function __invoke(DestroyLivroCommand $command): void
    {
        $livro = $command->livro;

        // 1. Lógica de Negócio
        if ($livro->movimentacoes()->exists()) {
        
            throw new \Exception('Não é possível excluir este livro, pois existem movimentações vinculadas.');
        }

        // 2. Lógica de Persistência (Exclusão)
        $livro->delete();
    }
}