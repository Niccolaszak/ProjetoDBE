<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SetoresController extends Controller
{
    public function index()
    {
        $setores = Setor::all();
        //$setores = Setor::whereNotIn('nome', ['Admin', 'Teste'])->get();
        return view('setores.index', compact('setores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (\App\Models\Setor::where('nome', $value)->exists()) {
                        $fail('Já existe um setor com esse nome.');
                    }
                },
            ],
            'descricao' => ['nullable', 'string'],
        ]);

        Setor::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }


    public function destroy($id): RedirectResponse
    {
        $setor = Setor::findOrFail($id);
        if ($setor->users()->exists()) {
            return redirect()
                ->route('setores.index')
                ->with('error', 'Não é possível excluir este setor, pois existem usuários vinculados a ele.');
        }

        if ($setor->permissoes()->exists()) {
            return redirect()
                ->route('setores.index')
                ->with('error', 'Não é possível excluir este setor, pois existem permissões vinculadas a ele.');
        }

        $setor->delete();

        return redirect()
            ->route('setores.index')
            ->with('success', 'Setor excluído com sucesso!');
    }
}