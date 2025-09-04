<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\PermissaoService;

class CheckPermission
{
    protected $permissaoService;

    public function __construct(PermissaoService $permissaoService)
    {
        $this->permissaoService = $permissaoService;
    }

    public function handle($request, Closure $next)
    {
        $rotaAtual = $request->route()->getName();
        $user = $request->user();

        if (! $this->permissaoService->podeAcessarRota($user, $rotaAtual)) {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}