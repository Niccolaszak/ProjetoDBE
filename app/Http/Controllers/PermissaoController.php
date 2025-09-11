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

        $telas = Tela::all();
        $cargos = Cargo::all();
        $setores = Setor::all();

        $cargosFiltrados = $cargos->filter(function($c) {
            return $c->nome !== 'Admin' && $c->nome !== 'Teste'; 
        });

        $setoresFiltrados = $setores->filter(function($s) {
            return $s->nome !== 'Admin' && $s->nome !== 'Teste';
        });

        $telasFiltradas = $telas->filter(function($t) {
            return $t->nome !== 'Consultar Painel';
        });

        return view('permissoes.index', compact('permissoes', 'cargosFiltrados', 'setoresFiltrados', 'telasFiltradas'));
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

        $telasFiltradas = $telas->filter(function($t) {
            return $t->nome !== 'Consultar Painel';
        });

        return view('permissoes.index', compact('telasFiltradas', 'cargosFiltrados', 'setoresFiltrados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tela_id' => 'required|exists:telas,id',
            'cargo_id' => 'required|exists:cargos,id',
            'setor_id' => [
                'required',
                'exists:setores,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \App\Models\Permissao::where('tela_id', $request->tela_id)
                        ->where('cargo_id', $request->cargo_id)
                        ->where('setor_id', $request->setor_id)
                        ->exists();

                    if ($exists) {
                        $fail('Essa permissão já existe para esta tela, cargo e setor.');
                    }
                },
            ],
        ]);

        Permissao::create($request->only('tela_id', 'cargo_id', 'setor_id'));

        $telasComExtras = [1];

        if ($request->tela_id >= 2 && $request->tela_id <= 11) {
        foreach ($telasComExtras as $telaExtraId) {
            // Checa se já existe para não duplicar
            $exists = \App\Models\Permissao::where('tela_id', $telaExtraId)
                ->where('cargo_id', $request->cargo_id)
                ->where('setor_id', $request->setor_id)
                ->exists();

            if (!$exists) {
                Permissao::create([
                    'tela_id' => $telaExtraId,
                    'cargo_id' => $request->cargo_id,
                    'setor_id' => $request->setor_id,
                ]);
            }
        }
    }

        return redirect()->route('permissoes.index')->with('success', 'Permissão criada!');
    }
    
    public function destroy($id)
    {
        $permissao = Permissao::findOrFail($id);
        $permissao->delete();

        return redirect()->route('permissoes.index')
                        ->with('success', 'Permissão excluída com sucesso!');
    }
}