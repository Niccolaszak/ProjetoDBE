<?php

namespace App\Http\Controllers\Auth;

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

class RegisteredUserController extends Controller
{
    public function index()
    {
        $users = User::with(['cargo', 'setor'])->get();

        return view('users.index', compact('users'));
    }
    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $cargosParaExcluir = [1]; 
        $setoresParaExcluir = [1];
        $cargos = Cargo::whereNotIn('id', $cargosParaExcluir)->get();
        $setores = Setor::whereNotIn('id', $setoresParaExcluir)->get();

        return view('auth.register', compact('cargos', 'setores'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
}
