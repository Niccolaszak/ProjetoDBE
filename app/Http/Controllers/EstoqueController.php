<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstoqueController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Estoque::class, 'estoque');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {      
        $estoques = Estoque::with('livro.genero')->get();
        return view('estoques.index', compact('estoques'));
    }
}