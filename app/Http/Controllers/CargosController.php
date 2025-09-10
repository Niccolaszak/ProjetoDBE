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
        //$cargos = Cargo::whereNotIn('nome', ['Admin', 'Teste'])->get();
        return view('cargos.index', compact('cargos'));
    }

    public function create()
    {
        return view('cargos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (\App\Models\Cargo::where('nome', $value)->exists()) {
                        $fail('Já existe um cargo com esse nome.');
                    }
                },
            ],
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
