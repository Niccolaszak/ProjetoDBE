<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Usuários
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'users.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'novo-usuario')">
                    Novo Usuário
                </x-primary-button>

                <x-modal name="novo-usuario" :show="false" focusable>
                    <form method="POST" action="{{ route('users.store') }}" class="p-6 space-y-6">
                        @csrf

                        <h2 class="text-lg font-medium text-gray-900">
                            Registrar Funcionário
                        </h2>

                        <!-- Nome Completo -->
                        <div>
                            <x-input-label for="name" :value="__('Nome Completo')" />
                            <x-text-input id="name" class="block mt-1 w-full"
                                type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full"
                                type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Cargo -->
                        <div>
                            <x-custom-select name="cargo_id" :options="$cargosFiltrados" label="Cargo" placeholder="Selecione o cargo" />
                            <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
                        </div>

                        <!-- Setor -->
                        <div>
                            <x-custom-select name="setor_id" :options="$setoresFiltrados" label="Setor" placeholder="Selecione o setor" />
                            <x-input-error :messages="$errors->get('setor_id')" class="mt-2" />
                        </div>

                        <!-- Salário -->
                        <div>
                            <x-input-label for="salario" :value="__('Salário')" />
                            <x-text-input id="salario" class="block mt-1 w-full"
                                type="number" name="salario"
                                value="{{ old('salario') }}" required step="0.01" />
                            <x-input-error :messages="$errors->get('salario')" class="mt-2" />
                        </div>

                        <!-- Aviso de senha -->
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                Por padrão, a senha do usuário criado será <span class="font-semibold">12345678</span>.
                                No primeiro login, o sistema forçará o usuário a redefini-la.
                            </p>
                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end gap-4 mt-6">
                            <x-secondary-button x-on:click="$dispatch('close')" type="button">
                                Cancelar
                            </x-secondary-button>

                            <x-primary-button type="submit">
                                Registrar
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            @endif
        </div>
    </x-slot>


    <div class="overflow-x-auto p-6">
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="usuariosTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Nome ⬍ <br>
                        <input id="filtro-nome" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar nome...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Cargo ⬍ <br>
                        <input id="filtro-cargo" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar cargo...">
                    </th>
                    <th colspan="3" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Setor ⬍ <br>
                        <input id="filtro-setor" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar setor...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $u->name }}</td>
                        <td class="px-4 py-2">{{ $u->cargo->nome }}</td>
                        <td class="px-4 py-2">{{ $u->setor->nome }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'users.update'))
                        <td>
                            <!-- Botão Editar -->
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-usuario-edit-{{ $u->id }}')">
                                Editar
                            </x-secondary-button>

                            <!-- Modal de Edição -->
                            <x-modal name="confirm-usuario-edit-{{ $u->id }}" focusable>
                                <div class="flex justify-center mt-6">
                                    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                            Editar Funcionário
                                        </h2>
                                        <form method="POST" action="{{ route('users.update', $u->id) }}" class="space-y-6">
                                            @csrf
                                            @method('PUT')
                                            <!-- Nome -->
                                            <div>
                                                <x-input-label for="name" :value="__('Nome Completo')" />
                                                <x-text-input id="name" class="block mt-1 w-full"
                                                    type="text" name="name"
                                                    :value="old('name', $u->name)" required autofocus autocomplete="name" />
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>

                                            <!-- Email -->
                                            <div>
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" class="block mt-1 w-full"
                                                    type="email" name="email"
                                                    :value="old('email', $u->email)" required autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>
                                            <div>
                                                <x-custom-select
                                                    name="cargo_id"
                                                    :options="$cargosFiltrados"
                                                    :label="'Cargo'"
                                                    :placeholder="'-- Selecione o cargo --'"
                                                    :selected="old('cargo_id', $u->cargo_id)"
                                                />

                                                <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-custom-select
                                                    name="setor_id"
                                                    :options="$setoresFiltrados"
                                                    :label="'Setor'"
                                                    :placeholder="'-- Selecione o setor --'"
                                                    :selected="old('setor_id', $u->setor_id)"
                                                />

                                                <x-input-error :messages="$errors->get('cargo_id')" class="mt-2" />
                                            </div>

                                            <!-- Salário -->
                                            <div>
                                                <x-input-label for="salario" :value="__('Salário')" />
                                                <x-text-input id="salario" class="block mt-1 w-full"
                                                    type="number" name="salario"
                                                    :value="old('salario', $u->salario)" required step="0.01" />
                                                <x-input-error :messages="$errors->get('salario')" class="mt-2" />
                                            </div>

                                            <!-- Aviso de senha -->
                                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <p class="text-sm text-yellow-700">
                                                    Somente o usuário pode alterar sua senha.
                                                </p>
                                            </div>

                                            <!-- Botões -->
                                            <div class="flex justify-between items-center mt-6">
                                                <x-secondary-button @click="$dispatch('close')" type="button">
                                                    ← Fechar
                                                </x-secondary-button>

                                                <x-primary-button type="submit">
                                                    Salvar
                                                </x-primary-button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                        <td>
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-usuario-deletion-{{ $u->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-usuario-deletion-{{ $u->id }}" focusable>
                                <form method="POST" action="{{ route('users.destroy', $u->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir este usuário?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        Esta ação é permanente e não poderá ser desfeita.
                                    </p>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            Cancelar
                                        </x-secondary-button>

                                        <x-danger-button class="ms-3">
                                            Excluir
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div  class="flex justify-end mt-6 pr-6">
            <x-primary-button x-data="" class="ms-4" x-on:click="window.location.href='{{ route('painel') }}'">
                {{ __('Voltar') }}
            </x-primary-button>
        </div>
    </div>

    <script>

        function filtrarTabela() {
            const table = document.getElementById("usuariosTable");
            const rows = table.getElementsByTagName("tr");
            const inputs = table.querySelectorAll("thead input");

            for (let i = 1; i < rows.length; i++) {
                let visible = true;
                inputs.forEach(input => {
                    const col = input.getAttribute("data-col");
                    const filtro = input.value.toLowerCase();
                    let cell = rows[i].getElementsByTagName("td")[col];
                    if (cell) {
                        let txtValue = cell.textContent || cell.innerText;
                        if (!txtValue.toLowerCase().includes(filtro)) {
                            visible = false;
                        }
                    }
                });
                rows[i].style.display = visible ? "" : "none";
            }
        }


        let sortDirection = {}; 

        function ordenarTabela(colIndex) {
            const table = document.getElementById("usuariosTable");
            const tbody = table.tBodies[0];
            const rows = Array.from(tbody.querySelectorAll("tr"));


            sortDirection[colIndex] = !sortDirection[colIndex];

            rows.sort((a, b) => {
                let aText = a.cells[colIndex].innerText.toLowerCase();
                let bText = b.cells[colIndex].innerText.toLowerCase();

                if (aText < bText) return sortDirection[colIndex] ? -1 : 1;
                if (aText > bText) return sortDirection[colIndex] ? 1 : -1;
                return 0;
            });


            rows.forEach(row => tbody.appendChild(row));
        }
    </script>

</x-app-layout>