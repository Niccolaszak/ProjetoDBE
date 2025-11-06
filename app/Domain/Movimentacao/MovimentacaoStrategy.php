<?php
// app/Domain/Movimentacao/MovimentacaoStrategy.php
namespace App\Domain\Movimentacao;

use App\Models\Movimentacao;

/**
 * Esta interface define o contrato que todas as estratégias
 * de movimentação de estoque devem seguir.
 */
interface MovimentacaoStrategy
{
    /**
     * @param Movimentacao $movimentacao
     * @return void
     * @throws \Exception
     */
    public function processar(Movimentacao $movimentacao): void;

    /**
     * @param Movimentacao $movimentacao
     * @return void
     * @throws \Exception
     */
    public function reverter(Movimentacao $movimentacao): void;
}