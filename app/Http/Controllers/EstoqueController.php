<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\View\View;

class EstoqueController extends Controller
{
    public function index(): View
    {
        $estoques = Estoque::with('livro')->get();
        return view('estoques.index', compact('estoques'));
    }

    public function show(Estoque $estoque): View
    {
        return view('estoques.show', compact('estoque'));
    }
}