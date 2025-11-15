<?php

namespace App\Services;

use App\Models\User;
use App\Models\Permissao;

class PermissaoService
{
    public function podeAcessarRota($user, $rota)
    {
        $permissoes = Permissao::where('cargo_id', $user->cargo_id)
                                ->where('setor_id', $user->setor_id)
                                ->get();

        foreach ($permissoes as $p) {
            if (in_array($rota, $p->tela->rotas)) {
                return true;
            }
        }

        return false;
    }
}