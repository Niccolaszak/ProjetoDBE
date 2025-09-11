<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movimentações
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'movimentacoes.store'))
            <!-- Botão para abrir modal -->
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'nova-movimentacao')">
                Nova Movimentação
            </x-primary-button>
            <!-- Modal -->
            <x-modal name="nova-movimentacao" :show="false" focusable>
                <form action="{{ route('movimentacoes.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        Nova Movimentação
                    </h2>

                    <!-- Seleção de Livro -->
                    <div class="mt-4">
                        <x-input-label for="livro_id" :value="__('Livro')" />
                        <select id="livro_id" name="livro_id" required class="mt-1 block w-full border rounded">
                            <option value="">-- Selecione o livro --</option>
                            @foreach($livros as $livro)
                                <option value="{{ $livro->id }}">{{ $livro->titulo }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('livro_id')" class="mt-2" />
                    </div>

                    <!-- Quantidade -->
                    <div class="mt-4">
                        <x-input-label for="quantidade" :value="__('Quantidade')" />
                        <x-text-input id="quantidade" name="quantidade" type="number" min="1" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('quantidade')" class="mt-2" />
                    </div>

                    <!-- Tipo (Entrada/Saída) -->
                    <div class="mt-4">
                        <x-input-label for="tipo" :value="__('Tipo')" />
                        <select id="tipo" name="tipo" required class="mt-1 block w-full border rounded">
                            <option value="">-- Selecione o tipo --</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                    </div>

                    <!-- Campo oculto do responsável -->
                    <input type="hidden" name="responsavel" value="{{ auth()->user()->id }}" />

                    <!-- Observação -->
                    <div class="mt-4">
                        <x-input-label for="observacao" :value="__('Observação')" />
                        <x-text-area id="observacao" name="observacao" rows="3" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('observacao')" class="mt-2" />
                    </div>

                    <!-- Botões -->
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

    <!-- Tabela de Movimentações -->
    <div class="overflow-x-auto p-6">
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="movimentacoesTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Livro ⬍ <br>
                        <input id="filtro-livro" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar livro...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Tipo ⬍ <br>
                        <input id="filtro-tipo" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar tipo...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Quantidade ⬍ <br>
                        <input id="filtro-quantidade" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar quantidade...">
                    </th>
                    <th colspan="2" class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(3)">
                        Responsável ⬍ <br>
                        <input id="filtro-responsavel" type="text" onkeyup="filtrarTabela()" data-col="3" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar responsável...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimentacoes as $mov)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 cursor-pointer" x-data 
                    @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'movimentacoes.store'))
                    x-on:dblclick="$dispatch('open-modal', 'show-mov-{{ $mov->id }}')"
                    @endif>
                        <td class="px-4 py-2">{{ $mov->livro->titulo }}</td>
                        <td class="px-4 py-2">{{ ucfirst($mov->tipo) }}</td>
                        <td class="px-4 py-2">{{ $mov->quantidade }}</td>
                        <td class="px-4 py-2">{{ $mov->responsavel }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'movimentacoes.store'))
                        <td>
                            <x-secondary-button class="px-1 py-0.5 text-xs"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-movimentacao-deletion-{{ $mov->id }}')"
                            >
                                Excluir
                            </x-secondary-button>

                            <x-modal name="confirm-movimentacao-deletion-{{ $mov->id }}" focusable>
                                <form method="POST" action="{{ route('movimentacoes.destroy', $mov->id) }}" class="p-6">
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Tem certeza que deseja excluir esta movimentação?
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

                        <x-modal name="show-mov-{{ $mov->id }}" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                                    Detalhes da Movimentação e do Livro
                                </h2>

                                <div class="space-y-3">
                                    <!-- Dados do Livro -->
                                    <p><strong>Título:</strong> {{ $mov->livro->titulo }}</p>
                                    <p><strong>Autor:</strong> {{ $mov->livro->autor }}</p>
                                    <p><strong>Gênero:</strong> {{ $mov->livro->genero->genero }}</p>
                                    <p><strong>Descrição do Livro:</strong> {{ $mov->livro->descricao_livro }}</p>

                                    <!-- Dados da Movimentação -->
                                    <p><strong>Tipo:</strong> {{ ucfirst($mov->tipo) }}</p>
                                    <p><strong>Quantidade:</strong> {{ $mov->quantidade }}</p>
                                    <p><strong>Responsável:</strong> {{ $mov->responsavel }}</p>
                                    <p><strong>Observação:</strong> {{ $mov->observacao ?? '-' }}</p>
                                    <p><strong>Data/Hora:</strong> {{ $mov->created_at->format('d/m/Y H:i') }}</p>
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

        <div class="flex justify-end mt-6 pr-6">
            <x-primary-button class="ms-4" onclick="window.location='{{ route('painel') }}'">
                {{ __('Voltar') }}
            </x-primary-button>
        </div>
    </div>

    <script>
        // Função de filtro
        function filtrarTabela() {
            const table = document.getElementById("movimentacoesTable");
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

        // Função de ordenação
        let sortDirection = {};
        function ordenarTabela(colIndex) {
            const table = document.getElementById("movimentacoesTable");
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