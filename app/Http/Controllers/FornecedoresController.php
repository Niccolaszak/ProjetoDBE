<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FornecedorController extends Controller
{
    public function index(): View
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:50',
            'razao_social' => 'required|string|max:150',
            'cpf_cnpj' => 'required|string|max:20|unique:fornecedores,cpf_cnpj',
            'email' => 'email|max:100',
            'telefone' => 'string|max:20',
            'endereco' => 'string|max:150',
            'cidade' => 'string|max:100',
            'pais' => 'string|max:50',
            'cep' => 'string|max:10',
            'pix' => 'string|max:100',
            'conta_corrente' => 'string|max:50',
            'agencia' => 'string|max:20',
        ]);

        Fornecedor::create($request->all());

        return redirect()->route('fornecedores.index')
                         ->with('success', 'Fornecedor criado com sucesso!');
    }

    public function update(Request $request, Fornecedor $fornecedor): RedirectResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:50',
            'razao_social' => 'required|string|max:150',
            'cpf_cnpj' => 'required|string|max:20|unique:fornecedores,cpf_cnpj,' . $fornecedor->id,
            'email' => 'email|max:100',
            'telefone' => 'string|max:20',
            'endereco' => 'string|max:150',
            'cidade' => 'string|max:100',
            'pais' => 'string|max:50',
            'cep' => 'string|max:10',
            'pix' => 'string|max:100',
            'conta_corrente' => 'string|max:50',
            'agencia' => 'string|max:20',
        ]);

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')
                         ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Fornecedor $fornecedor): RedirectResponse
    {
        if ($fornecedor->movimentacoes()->exists()) {
            return redirect()->route('fornecedores.index')
                             ->with('error', 'Não é possível excluir este fornecedor, pois existem movimentações vinculadas.');
        }

        $fornecedor->delete();

        return redirect()->route('fornecedores.index')
                         ->with('success', 'Fornecedor excluído com sucesso!');
    }
}