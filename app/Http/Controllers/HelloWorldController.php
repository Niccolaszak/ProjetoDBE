<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
    public function exibirMensagem(){
        return "Olá Prof! Esta é a rota HelloWorld que solicitou! <br><h3>Solicitação:</h3>Primeira Rota e Controller Simples: Uma rota básica e um controller
correspondente que retorne um \"Hello World\" ou uma lista simples de
dados em memória, apenas para demonstrar a configuração inicial do
Laravel.";
    }
}
