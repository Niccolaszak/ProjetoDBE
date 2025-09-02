<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcarRedefinirSenha
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->forcar_redefinir_senha) {
            return redirect()->route('senha.redefinir'); // rota que vamos criar
        }

        return $next($request);
    }
}