<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissao;
use App\Models\Tela;
use App\Models\Cargo;
use App\Models\Setor;

class PermissaoController extends Controller
{
    public function index()
    {
        $permissoes = Permissao::with(['tela', 'cargo', 'setor'])
            /*->whereHas('cargo', function($q) {
                $q->where('nome', '!=', 'Admin');
            })*/
            ->get();

        return view('permissoes.index', compact('permissoes'));
    }


    public function create()
    {
        $telas = Tela::all();
        $cargos = Cargo::all();
        $setores = Setor::all();

        $cargosFiltrados = $cargos->filter(function($c) {
            return $c->nome !== 'Admin' && $c->nome !== 'Teste'; 
        });

        $setoresFiltrados = $setores->filter(function($s) {
            return $s->nome !== 'Admin' && $s->nome !== 'Teste';
        });

        return view('permissoes.create', compact('telas', 'cargosFiltrados', 'setoresFiltrados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tela_id' => 'required|exists:telas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'setor_id' => 'required|exists:setores,id',
        ]);

        Permissao::create($request->only('tela_id', 'cargo_id', 'setor_id'));

        return redirect()->route('permissoes.index')->with('success', 'Permissão criada!');
    }

    public function destroy(Permissao $permissao)
    {
        $permissao->delete();
        return redirect()->route('permissoes.index')->with('success', 'Permissão removida!');
    }
}