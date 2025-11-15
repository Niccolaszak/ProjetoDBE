<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Adiciona o construtor para autorização automática via Policy.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::with(['cargo', 'setor'])
        /*->whereHas('cargo', function($q) {
                $q->where('nome', '!=', 'Admin');
                $q->where('nome', '!=', 'Teste');
            })*/
        ->get();

        $cargos = Cargo::all();
        $setores = Setor::all();

        $cargosFiltrados = $cargos->filter(fn($c) => !in_array($c->nome, ['Admin', 'Teste']));
        $setoresFiltrados = $setores->filter(fn($s) => !in_array($s->nome, ['Admin', 'Teste']));

        return view('users.index', compact('users', 'cargosFiltrados', 'setoresFiltrados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'cargo_id'  => ['required', 'exists:cargos,id'],
            'setor_id'  => ['required', 'exists:setores,id'],
            'salario'   => ['required', 'numeric', 'min:0'],
        ]);

        $user = User::create([
            'name'                     => $request->name,
            'email'                    => $request->email,
            'password'                 => Hash::make('12345678'),
            'cargo_id'                 => $request->cargo_id,
            'cargo_nome'               => Cargo::find($request->cargo_id)->nome,
            'setor_id'                 => $request->setor_id,
            'setor_nome'               => Setor::find($request->setor_id)->nome,
            'salario'                  => $request->salario,
            'forcar_redefinir_senha'   => true,
        ]);

        event(new Registered($user));

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'cargo_id'  => ['required', 'exists:cargos,id'],
            'setor_id'  => ['required', 'exists:setores,id'],
            'salario'   => ['required', 'numeric', 'min:0'],
        ]);

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'cargo_id'    => $request->cargo_id,
            'cargo_nome'  => Cargo::find($request->cargo_id)->nome,
            'setor_id'    => $request->setor_id,
            'setor_nome'  => Setor::find($request->setor_id)->nome,
            'salario'     => $request->salario,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Impede auto-exclusão
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        // Impede exclusão do admin
        if ($user->email === "admin@admin.com") {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir o usuário admin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}