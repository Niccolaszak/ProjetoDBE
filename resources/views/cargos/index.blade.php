<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Cargos
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'cargos.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'novo-cargo')">
                    Novo Cargo
                </x-primary-button>
                <x-modal name="novo-cargo" :show="false" focusable>
                    <form action="{{ route('cargos.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <h2 class="text-lg font-medium text-gray-900">
                            Novo Cargo
                        </h2>

                        {{-- Nome do Cargo --}}
                        <div class="mt-4">
                            <x-input-label for="nome" :value="__('Nome do Cargo')" />
                            <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                        </div>

                        {{-- Descrição --}}
                        <div class="mt-4">
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <x-text-area id="descricao" name="descricao" class="mt-1 block w-full" rows="3" />
                            <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                        </div>

                        {{-- Botões --}}
                        <div class="flex justify-end gap-4 mt-6">
                            <x-secondary-button x-on:click="$dispatch('close')" type="button">
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
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="cargosTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Cargo ⬍ <br>
                        <input id="filtro-cargo" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar cargo...">
                    </th>
                    <th colspan="2" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Descrição ⬍ <br>
                        <input id="filtro-descricao" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar descrição...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($cargos as $cargo)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $cargo->nome }}</td>
                        <td class="px-4 py-2">{{ $cargo->descricao }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'cargos.store'))
                        <td>
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-cargo-deletion-{{ $cargo->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-cargo-deletion-{{ $cargo->id }}" focusable>
                                <form method="POST" action="{{ route('cargos.destroy', $cargo->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir este cargo?
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
            const table = document.getElementById("cargosTable");
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
            const table = document.getElementById("cargosTable");
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