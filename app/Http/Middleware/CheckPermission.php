<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Permissao;
use App\Models\Tela;

class CheckPermission
{
    public function handle($request, Closure $next)
    {
        $rotaAtual = $request->route()->getName(); // pega a rota
        $user = $request->user();

        $permissao = Permissao::whereHas('tela', function($q) use ($rotaAtual) {
            $q->where('rota', $rotaAtual);
        })->where('cargo_id', $user->cargo_id)
          ->where('setor_id', $user->setor_id)
          ->first();

        if (!$permissao) {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}