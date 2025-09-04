<?php

namespace App\Services;

use App\Models\User;
use App\Models\Permissao;

class PermissaoService
{
    /**
     * Verifica se o usuário pode acessar uma rota pelo nome dela.
     */
    public function podeAcessarRota(User $user, string $rota): bool
    {
        return Permissao::whereHas('tela', function ($q) use ($rota) {
                $q->where('rota', $rota);
            })
            ->where('cargo_id', $user->cargo_id)
            ->where('setor_id', $user->setor_id)
            ->exists();
    }

    /**
     * Verifica se o usuário pode acessar uma tela específica (por ID).
     */
    public function podeAcessarTela(User $user, int $telaId): bool
    {
        return Permissao::where('tela_id', $telaId)
            ->where('cargo_id', $user->cargo_id)
            ->where('setor_id', $user->setor_id)
            ->exists();
    }
}