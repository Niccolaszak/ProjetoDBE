<?php
// app/Domain/Movimentacao/Strategies/EntradaStrategy.php
namespace App\Domain\Movimentacao\Strategies;

use App\Domain\Movimentacao\MovimentacaoStrategy;
use App\Models\Estoque;
use App\Models\Movimentacao;
use InvalidArgumentException;

class EntradaStrategy implements MovimentacaoStrategy
{
    public function processar(Movimentacao $movimentacao): void
    {
        $estoque = $this->getEstoque($movimentacao);

        $estoque->quantidade_disponivel += $movimentacao->quantidade;
        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }

    public function reverter(Movimentacao $movimentacao): void
    {
        $estoque = $this->getEstoque($movimentacao);

        if ($estoque->quantidade_disponivel < $movimentacao->quantidade) {
            throw new InvalidArgumentException("Não é possível reverter/excluir esta entrada: o estoque disponível é menor que a quantidade da entrada.");
        }

        $estoque->quantidade_disponivel -= $movimentacao->quantidade;
        $estoque->ultima_movimentacao = now();
        $estoque->save();
    }

    //Busca o estoque ou cria um novo se não existir.
     
    private function getEstoque(Movimentacao $movimentacao): Estoque
    {
        return $movimentacao->livro->estoque()->firstOrCreate(
            ['livro_id' => $movimentacao->livro_id],
            [
                'quantidade_disponivel' => 0,
                'quantidade_consumida' => 0,
            ]
        );
    }
}