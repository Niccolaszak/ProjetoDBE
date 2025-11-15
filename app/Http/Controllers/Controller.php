<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * AuthorizesRequests: Adiciona o 'authorizeResource' e 'Gate::authorize'
     * ValidatesRequests: Adiciona o '$request->validate()'
     */
    use AuthorizesRequests, ValidatesRequests;
}