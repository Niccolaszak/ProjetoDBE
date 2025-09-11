<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Permissões
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'permissoes.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'nova-permissao')">
                    Nova Permissão
                </x-primary-button>
                <x-modal name="nova-permissao" :show="false" focusable>
                    <form action="{{ route('permissoes.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <h2 class="text-lg font-medium text-gray-900">
                            Nova Permissão
                        </h2>

                        <!-- Tela -->
                        <x-custom-select name="tela_id" :options="$telasFiltradas" label="Tela" placeholder="Selecione a tela" />

                        <!-- Cargo -->
                        <x-custom-select name="cargo_id" :options="$cargosFiltrados" label="Cargo" placeholder="Selecione o cargo" />

                        <!-- Setor -->
                        <x-custom-select name="setor_id" :options="$setoresFiltrados" label="Setor" placeholder="Selecione o setor" />

                        <!-- Botões -->
                        <div class="flex justify-end gap-4 mt-4">
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
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="permissoesTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Tela ⬍ <br>
                        <input id="filtro-tela" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar tela...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Cargo ⬍ <br>
                        <input id="filtro-cargo" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar cargo...">
                    </th>
                    <th colspan="2" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Setor ⬍ <br>
                        <input id="filtro-setor" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar setor...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissoes as $p)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $p->tela->nome }}</td>
                        <td class="px-4 py-2">{{ $p->cargo->nome }}</td>
                        <td class="px-4 py-2">{{ $p->setor->nome }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'permissoes.store'))
                        <td>
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-permissao-deletion-{{ $p->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-permissao-deletion-{{ $p->id }}" focusable>
                                <form method="POST" action="{{ route('permissoes.destroy', $p->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir esta permissão?
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
            const table = document.getElementById("permissoesTable");
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
            const table = document.getElementById("permissoesTable");
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

        const button = document.getElementById('dropdownButton');
        const menu = document.getElementById('dropdownMenu');
        const hiddenInput = document.getElementById('tela_id_hidden');

        // Abrir/fechar dropdown
        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Selecionar opção
        menu.querySelectorAll('li').forEach(item => {
            item.addEventListener('click', () => {
                button.firstChild.textContent = item.textContent;
                hiddenInput.value = item.dataset.value;
                menu.classList.add('hidden');
            });
        });

        // Fechar dropdown se clicar fora
        document.addEventListener('click', (e) => {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>