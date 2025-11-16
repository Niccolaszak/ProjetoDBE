<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Interfaces\EstoqueRepositoryInterface;

class EstoqueController extends Controller
{
    private EstoqueRepositoryInterface $estoqueRepository;

    public function __construct(EstoqueRepositoryInterface $estoqueRepository)
    {
        $this->estoqueRepository = $estoqueRepository;
        $this->authorizeResource(Estoque::class, 'estoque');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {      
        $estoques = $this->estoqueRepository->allWithLivroGenero();
        return view('estoques.index', compact('estoques'));
    }
}