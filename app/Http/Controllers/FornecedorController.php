<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Interfaces\FornecedorRepositoryInterface;

class FornecedorController extends Controller
{

    private FornecedorRepositoryInterface $fornecedorRepository;

    public function __construct(FornecedorRepositoryInterface $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
        $this->authorizeResource(Fornecedor::class, 'fornecedor');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $fornecedores = $this->fornecedorRepository->all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'tipo' => ['required', Rule::in(['CNPJ', 'CPF'])],
            'razao_social' => ['required', 'string', 'max:150'],
            'cnpj_cpf' => [
                'required',
                'string',
                'max:20',
                Rule::unique('fornecedores', 'cnpj_cpf'),
            ],
            'email' => ['nullable', 'string', 'max:100'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco' => ['nullable', 'string', 'max:150'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'pais' => ['nullable', 'string', 'max:50'],
            'cep' => ['nullable', 'string', 'max:10'],
            'pix' => ['nullable', 'string', 'max:100'],
            'conta_corrente' => ['nullable', 'string', 'max:50'],
            'agencia' => ['nullable', 'string', 'max:20'],
        ]);

        $this->fornecedorRepository->create($validated);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedor $fornecedor): RedirectResponse
    {

        $validated = $request->validate([
            'tipo' => ['required', Rule::in(['CNPJ', 'CPF'])],
            'razao_social' => 'required|string|max:150',
            'cnpj_cpf' => [
                'required',
                'string',
                'max:20',
                Rule::unique('fornecedores', 'cnpj_cpf')->ignore($fornecedor->id)
            ],
            'email' => 'nullable|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:150',
            'cidade' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:50',
            'cep' => 'nullable|string|max:10',
            'pix' => 'nullable|string|max:100',
            'conta_corrente' => 'nullable|string|max:50',
            'agencia' => 'nullable|string|max:20',
        ]);

        $this->fornecedorRepository->update($fornecedor, $validated);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor): RedirectResponse
    {
        if ($this->fornecedorRepository->hasMovimentacoes($fornecedor)) {
            return redirect()->route('fornecedores.index')->with('error', 'Não é possível excluir este fornecedor, pois existem movimentações vinculadas.');
        }

        $this->fornecedorRepository->delete($fornecedor);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}