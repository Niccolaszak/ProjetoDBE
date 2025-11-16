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

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\CargoRepositoryInterface;
use App\Interfaces\SetorRepositoryInterface;

class UserController extends Controller
{

    private UserRepositoryInterface $userRepository;
    private CargoRepositoryInterface $cargoRepository;
    private SetorRepositoryInterface $setorRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CargoRepositoryInterface $cargoRepository,
        SetorRepositoryInterface $setorRepository
    ) {
        $this->userRepository = $userRepository;
        $this->cargoRepository = $cargoRepository;
        $this->setorRepository = $setorRepository;
        
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $users = $this->userRepository->allWithCargoAndSetor();
        $cargos = $this->cargoRepository->all();
        $setores = $this->setorRepository->all();

        $cargosFiltrados = $cargos->filter(fn($c) => !in_array($c->nome, ['Admin', 'Teste']));
        $setoresFiltrados = $setores->filter(fn($s) => !in_array($s->nome, ['Admin', 'Teste']));

        return view('users.index', compact('users', 'cargosFiltrados', 'setoresFiltrados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'password'  => ['required', 'string', 'min:8', 'confirmed'], // Ajustado de 'defaults' para 'confirmed' se você tiver 'password_confirmation'
            'cargo_id'  => ['required', 'exists:cargos,id'],
            'setor_id'  => ['required', 'exists:setores,id'],
            'salario'   => ['required', 'numeric', 'min:0'],
        ]);

        $data = $validated;
        $data['password'] = Hash::make($request->password);
        
        $data['cargo_nome'] = $this->cargoRepository->all()->find($request->cargo_id)->nome;
        $data['setor_nome'] = $this->setorRepository->all()->find($request->setor_id)->nome;

        $user = $this->userRepository->create($data);

        event(new Registered($user));

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'cargo_id'  => ['required', 'exists:cargos,id'],
            'setor_id'  => ['required', 'exists:setores,id'],
            'salario'   => ['required', 'numeric', 'min:0'],
        ]);

        $data = $validated;
        
        $data['cargo_nome'] = $this->cargoRepository->all()->find($request->cargo_id)->nome;
        $data['setor_nome'] = $this->setorRepository->all()->find($request->setor_id)->nome;

        $this->userRepository->update($user, $data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        if ($user->email === "admin@admin.com") {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir o usuário admin.');
        }

        $this->userRepository->delete($user);

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}