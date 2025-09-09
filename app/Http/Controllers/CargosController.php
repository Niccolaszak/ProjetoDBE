<?php

namespace App\Http\Controllers;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CargosController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();
        return view('cargos.index', compact('cargos'));
    }


    public function create()
    {
        return view('cargos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'descricao' => ['nullable', 'string'],
        ]);

        Cargo::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('cargos.index')->with('success', 'Cargo criado com sucesso!');
    }

    public function destroy(Cargo $cargo): RedirectResponse
    {
        $cargo->delete();

        return redirect()->route('cargos.index')->with('success', 'Cargo excluído com sucesso!');
    }

}
