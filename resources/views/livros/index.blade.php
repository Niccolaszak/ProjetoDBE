<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Livros
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'livros.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'novo-livro')">
                    Novo Livro
                </x-primary-button>
                <x-modal name="novo-livro" :show="false" focusable>
                    <form method="POST" action="{{ route('livros.store') }}" class="p-6">
                        @csrf

                        <h2 class="text-lg font-medium text-gray-900">
                            Novo Livro
                        </h2>

                        {{-- Título do Livro --}}
                        <div class="mt-4">
                            <x-input-label for="titulo" :value="__('Título do Livro')" />
                            <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                        </div>

                        {{-- Autor --}}
                        <div class="mt-4">
                            <x-input-label for="autor" :value="__('Autor')" />
                            <x-text-input id="autor" name="autor" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('autor')" class="mt-2" />
                        </div>

                        {{-- Gênero --}}
                        <div class="mt-4">
                            <x-input-label for="genero_id" :value="__('Gênero')" />
                            <x-custom-select 
                                id="genero_id" 
                                name="genero_id" 
                                :options="$generosOptions" 
                                label="Gênero" 
                                placeholder="Selecione o gênero">
                            </x-custom-select>
                            <x-input-error :messages="$errors->get('genero_id')" class="mt-2" />
                        </div>

                        {{-- Descrição --}}
                        <div class="mt-4">
                            <x-input-label for="descricao_livro" :value="__('Descrição')" />
                            <x-text-area id="descricao_livro" name="descricao_livro" class="mt-1 block w-full" rows="3" />
                            <x-input-error :messages="$errors->get('descricao_livro')" class="mt-2" />
                        </div>


                        {{-- Botões --}}
                        <div class="mt-6 flex justify-end gap-4">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Cancelar
                            </x-secondary-button>

                            <x-primary-button type="submit">
                                Salvar
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            @endif
        </div>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="livrosTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Livro ⬍ <br>
                        <input id="filtro-livro" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar livro...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Autor ⬍ <br>
                        <input id="filtro-autor" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar autor...">
                    </th>
                    <th colspan="3" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Gênero ⬍ <br>
                        <input id="filtro-genero" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar gênero...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($livros as $livro)
                    <tr x-data x-on:dblclick="$dispatch('open-modal', 'show-livro-{{ $livro->id }}')" class="border-b border-gray-200 hover:bg-gray-50 cursor-pointer">
                        <td class="px-4 py-2">{{ $livro->titulo}}</td>
                        <td class="px-4 py-2">{{ $livro->autor}}</td>
                        <td class="px-4 py-2">{{ $livro->genero->genero}}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'livros.store'))
                        <td>
                            <!-- Botão Editar -->
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-livro-edit-{{ $livro->id }}')">
                                Editar
                            </x-secondary-button>

                            <!-- Modal de Edição -->
                            <x-modal name="confirm-livro-edit-{{ $livro->id }}" focusable>
                                <div class="flex justify-center mt-6">
                                    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                            Editar Livro
                                        </h2>
                                        <form method="POST" action="{{ route('livros.update', $livro->id) }}" class="space-y-6">
                                            @csrf
                                            @method('PUT')

                                            <!-- Título -->
                                            <div>
                                                <x-input-label for="titulo" :value="__('Título')" />
                                                <x-text-input id="titulo" class="block mt-1 w-full"
                                                    type="text" name="titulo"
                                                    :value="old('titulo', $livro->titulo)" required autofocus />
                                                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                                            </div>

                                            <!-- Autor -->
                                            <div>
                                                <x-input-label for="autor" :value="__('Autor')" />
                                                <x-text-input id="autor" class="block mt-1 w-full"
                                                    type="text" name="autor"
                                                    :value="old('autor', $livro->autor)" required />
                                                <x-input-error :messages="$errors->get('autor')" class="mt-2" />
                                            </div>

                                            <!-- Gênero -->
                                            <div>
                                                <x-custom-select
                                                    name="genero_id"
                                                    :options="$generosOptions"
                                                    :label="'Gênero'"
                                                    :placeholder="'-- Selecione o gênero --'"
                                                    :selected="old('genero_id', $livro->genero_id)"
                                                />                                                
                                                <x-input-error :messages="$errors->get('genero_id')" class="mt-2" />
                                            </div>

                                            <!-- Descrição -->
                                            <div>
                                                <x-input-label for="descricao_livro" :value="__('Descrição')" />
                                                <x-text-area id="descricao_livro" name="descricao_livro" class="mt-1 block w-full" rows="3" required>{{ old('descricao_livro', $livro->descricao_livro) }}</x-text-area>
                                                <x-input-error :messages="$errors->get('descricao_livro')" class="mt-2" />
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
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-livro-deletion-{{ $livro->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-livro-deletion-{{ $livro->id }}" focusable>
                                <form method="POST" action="{{ route('livros.destroy', $livro->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir este livro?
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

                        <x-modal name="show-livro-{{ $livro->id }}" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                                    Detalhes do Livro
                                </h2>

                                <div class="space-y-3">
                                    <p><strong>Título:</strong> {{ $livro->titulo }}</p>
                                    <p><strong>Autor:</strong> {{ $livro->autor }}</p>
                                    <p><strong>Gênero:</strong> {{ $livro->genero->genero }}</p>
                                    <p><strong>Descrição:</strong> {{ $livro->descricao_livro }}</p>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        Fechar
                                    </x-secondary-button>
                                </div>
                            </div>
                        </x-modal>
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
            const table = document.getElementById("livrosTable");
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
            const table = document.getElementById("livrosTable");
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