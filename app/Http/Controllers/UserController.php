<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use LogicException;
use App\Core\Users\Queries\ListarUsuariosQuery;
use App\Core\Users\Commands\CreateUserCommand;
use App\Core\Users\Handlers\CreateUserHandler;
use App\Core\Users\Commands\UpdateUserCommand;
use App\Core\Users\Handlers\UpdateUserHandler;
use App\Core\Users\Commands\DestroyUserCommand;
use App\Core\Users\Handlers\DestroyUserHandler;

class UserController extends Controller
{
    /**
     * Exibe a lista de usuários e os formulários.
     *
     * @param ListarUsuariosQuery $query
     * @return View
     */
    public function index(ListarUsuariosQuery $query): View
    {
        $data = $query->handle();

        return view('users.index', $data);
    }

    /**
     * Valida e armazena um novo usuário no banco de dados.
     *
     * @param Request $request
     * @param CreateUserHandler $handler
     * @return RedirectResponse
     */
    public function store(Request $request, CreateUserHandler $handler): RedirectResponse
    {
        // 1. Validação
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cargo_id' => ['required', 'integer', 'exists:cargos,id'],
            'setor_id' => ['required', 'integer', 'exists:setores,id'],
        ]);

        // 2. Cria o Command (DTO)
        $command = new CreateUserCommand(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
            cargo_id: (int) $validated['cargo_id'],
            setor_id: (int) $validated['setor_id']
        );

        // 3. Despacha para o Handler
        $handler($command);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Valida e atualiza um usuário existente.
     * @param Request $request
     * @param User $user (Injetado pela Rota-Model-Binding)
     * @param UpdateUserHandler $handler
     * @return RedirectResponse
     */
    public function update(Request $request, User $user, UpdateUserHandler $handler): RedirectResponse
    {
        // 1. Validação
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'cargo_id' => ['required', 'integer', 'exists:cargos,id'],
            'setor_id' => ['required', 'integer', 'exists:setores,id'],
            'forcar_redefinir_senha' => ['nullable', 'boolean'],
        ]);

        // 2. Cria o Command (DTO)
        $command = new UpdateUserCommand(
            user: $user,
            name: $validated['name'],
            email: $validated['email'],
            cargo_id: (int) $validated['cargo_id'],
            setor_id: (int) $validated['setor_id'],
            forcar_redefinir_senha: $request->has('forcar_redefinir_senha'),
            password: $validated['password'] // Pode ser nulo
        );

        // 3. Despacha para o Handler
        $handler($command);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário do banco de dados.
     * @param User $user (Injetado pela Rota-Model-Binding)
     * @param DestroyUserHandler $handler
     * @return RedirectResponse
     */
    public function destroy(User $user, DestroyUserHandler $handler): RedirectResponse
    {
        try {
            // 1. Cria o Command (DTO)
            $command = new DestroyUserCommand(
                userToDelete: $user,
                authenticatedUser: request()->user() // Pega o usuário logado
            );
            
            // 2. Despacha para o Handler
            $handler($command);

        } catch (LogicException $e) {
            // 3. Captura qualquer erro de regra de negócio
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}