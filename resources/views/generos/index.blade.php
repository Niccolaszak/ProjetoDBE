<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Gêneros
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'generos.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'novo-genero')">
                    Novo Gênero
                </x-primary-button>
                <x-modal name="novo-genero" :show="false" focusable>
                    <form method="POST" action="{{ route('generos.store') }}" class="p-6">
                        @csrf

                        <h2 class="text-lg font-medium text-gray-900">
                            Novo Gênero
                        </h2>

                        {{-- Nome do Gênero --}}
                        <div class="mt-4">
                            <x-input-label for="genero" :value="__('Nome do Gênero')" />
                            <x-text-input id="genero" name="genero" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('genero')" class="mt-2" />
                        </div>

                        {{-- Descrição --}}
                        <div class="mt-4">
                            <x-input-label for="descricao_genero" :value="__('Descrição')" />
                            <x-text-area id="descricao_genero" name="descricao_genero" class="mt-1 block w-full" rows="3" />
                            <x-input-error :messages="$errors->get('descricao_genero')" class="mt-2" />
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
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="generosTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Gênero ⬍ <br>
                        <input id="filtro-genero" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar gênero...">
                    </th>
                    <th colspan="2" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Descrição ⬍ <br>
                        <input id="filtro-descricao" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar descrição...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($generos as $genero)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $genero->genero }}</td>
                        <td class="px-4 py-2">{{ $genero->descricao_genero }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'generos.store'))
                        <td>
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-genero-deletion-{{ $genero->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-genero-deletion-{{ $genero->id }}" focusable>
                                <form method="POST" action="{{ route('generos.destroy', $genero->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir este genero?
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
            <x-primary-button class="ms-4" onclick="window.location='{{ route('painel') }}'">
                {{ __('Voltar') }}
            </x-primary-button>
        </div>
    </div>

    <script>

        function filtrarTabela() {
            const table = document.getElementById("generosTable");
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
            const table = document.getElementById("generosTable");
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