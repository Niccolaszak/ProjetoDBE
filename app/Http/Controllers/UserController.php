<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['cargo', 'setor'])
        /*->whereHas('cargo', function($q) {
                $q->where('nome', '!=', 'Admin');
                $q->where('nome', '!=', 'Teste');
            })*/
        ->get();

        $cargos = Cargo::all();
        $setores = Setor::all();

        $cargosFiltrados = $cargos->filter(function($c) {
            return $c->nome !== 'Admin' && $c->nome !== 'Teste'; 
        });

        $setoresFiltrados = $setores->filter(function($s) {
            return $s->nome !== 'Admin' && $s->nome !== 'Teste';
        });

        return view('users.index', compact('users', 'cargosFiltrados', 'setoresFiltrados'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'cargo_id' => ['required', 'exists:cargos,id'],
            'setor_id' => ['required', 'exists:setores,id'],
            'salario' => ['required', 'numeric', 'min:0'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            'cargo_id' => $request->cargo_id,
            'cargo_nome' => Cargo::find($request->cargo_id)->nome,
            'setor_id' => $request->setor_id,
            'setor_nome' => Setor::find($request->setor_id)->nome,
            'salario' => $request->salario,
            'forcar_redefinir_senha' => true,
        ]);

        event(new Registered($user));

        //Auth::login($user);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'cargo_id' => ['required', 'exists:cargos,id'],
            'setor_id' => ['required', 'exists:setores,id'],
            'salario' => ['required', 'numeric', 'min:0'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'cargo_id' => $request->cargo_id,
            'cargo_nome' => Cargo::find($request->cargo_id)->nome,
            'setor_id' => $request->setor_id,
            'setor_nome' => Setor::find($request->setor_id)->nome,
            'salario' => $request->salario,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Proteção: impedir que o admin delete a si mesmo
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Você não pode excluir sua própria conta.');
        }
        if ($user->email === "admin@admin.com") {
            return redirect()->route('users.index')->with('error', 'Você não pode excluir o usuário admin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
