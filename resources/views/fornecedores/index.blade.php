<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciar Fornecedores
            </h2>
            @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'fornecedores.store'))
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'novo-fornecedor')">
                    Novo Fornecedor
                </x-primary-button>
                <!-- Modal Novo Fornecedor -->
                <x-modal name="novo-fornecedor" :show="false" focusable>
                    <form method="POST" action="{{ route('fornecedores.store') }}" class="p-6 space-y-6">
                        @csrf
                        <h2 class="text-lg font-medium text-gray-900">Registrar Fornecedor</h2>

                        <div class="mt-4">
                            <x-custom-select
                                name="tipo"
                                :options="collect([
                                    (object)['id' => 'CNPJ', 'nome' => 'CNPJ'],
                                    (object)['id' => 'CPF', 'nome' => 'CPF']
                                ])"
                                label="Tipo de Fornecedor"
                                placeholder="-- Selecione o tipo --"
                            />
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="razao_social" :value="__('Razão Social')" />
                            <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="old('razao_social')" required />
                            <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="cnpj_cpf" :value="__('CNPJ/CPF')" />
                            <x-text-input id="cnpj_cpf" class="block mt-1 w-full" type="text" name="cnpj_cpf" :value="old('cnpj_cpf')" required />
                            <x-input-error :messages="$errors->get('cnpj_cpf')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="telefone" :value="__('Telefone')" />
                            <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone')" />
                            <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="endereco" :value="__('Endereço')" />
                            <x-text-input id="endereco" class="block mt-1 w-full" type="text" name="endereco" :value="old('endereco')" />
                            <x-input-error :messages="$errors->get('endereco')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="cidade" :value="__('Cidade')" />
                            <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade')" />
                            <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="pais" :value="__('País')" />
                            <x-text-input id="pais" class="block mt-1 w-full" type="text" name="pais" :value="old('pais')" />
                            <x-input-error :messages="$errors->get('pais')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="cep" :value="__('CEP')" />
                            <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" :value="old('cep')" />
                            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="pix" :value="__('PIX')" />
                            <x-text-input id="pix" class="block mt-1 w-full" type="text" name="pix" :value="old('pix')" />
                            <x-input-error :messages="$errors->get('pix')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="conta_corrente" :value="__('Conta Corrente')" />
                            <x-text-input id="conta_corrente" class="block mt-1 w-full" type="text" name="conta_corrente" :value="old('conta_corrente')" />
                            <x-input-error :messages="$errors->get('conta_corrente')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="agencia" :value="__('Agência')" />
                            <x-text-input id="agencia" class="block mt-1 w-full" type="text" name="agencia" :value="old('agencia')" />
                            <x-input-error :messages="$errors->get('agencia')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <x-secondary-button x-on:click="$dispatch('close')" type="button">Cancelar</x-secondary-button>
                            <x-primary-button type="submit">Registrar</x-primary-button>
                        </div>
                    </form>
                </x-modal>
            @endif
        </div>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="fornecedoresTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Tipo ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Tipo...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Razão Social ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Razão Social...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        CNPJ/CPF ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar CNPJ/CPF...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(3)">
                        Email ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="3" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Email...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(4)">
                        Telefone ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="4" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Telefone...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(5)">
                        Endereço ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="5" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Endereço...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(6)">
                        Cidade ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="6" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Cidade...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(7)">
                        País ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="7" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar País...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(8)">
                        CEP ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="8" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar CEP...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(9)">
                        PIX ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="9" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar PIX...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(10)">
                        Conta Corrente ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="10" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Conta Corrente...">
                    </th>
                    <th class="px-4 py-2 font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(11)">
                        Agência ⬍ <br>
                        <input type="text" onkeyup="filtrarTabela()" data-col="11" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Agência...">
                    </th>
                    <th class="px-4 py-2 text-gray-700">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fornecedores as $f)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $f->tipo }}</td>
                        <td class="px-4 py-2">{{ $f->razao_social }}</td>
                        <td class="px-4 py-2">{{ $f->cnpj_cpf }}</td>
                        <td class="px-4 py-2">{{ $f->email }}</td>
                        <td class="px-4 py-2">{{ $f->telefone }}</td>
                        <td class="px-4 py-2">{{ $f->endereco }}</td>
                        <td class="px-4 py-2">{{ $f->cidade }}</td>
                        <td class="px-4 py-2">{{ $f->pais }}</td>
                        <td class="px-4 py-2">{{ $f->cep }}</td>
                        <td class="px-4 py-2">{{ $f->pix }}</td>
                        <td class="px-4 py-2">{{ $f->conta_corrente }}</td>
                        <td class="px-4 py-2">{{ $f->agencia }}</td>
                        @if(app(\App\Services\PermissaoService::class)->podeAcessarRota(auth()->user(), 'fornecedores.store'))
                            <td class="px-4 py-2 flex gap-2">
                                <!-- Botões Editar / Excluir -->
                                <x-secondary-button class="px-1 py-0.5 text-xs"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-fornecedor-{{ $f->id }}')">
                                    Editar
                                </x-secondary-button>

                                <x-secondary-button class="px-1 py-0.5 text-xs"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'delete-fornecedor-{{ $f->id }}')">
                                    Excluir
                                </x-secondary-button>

                                <!-- Modals -->
                                <x-modal name="edit-fornecedor-{{ $f->id }}" focusable>
                                    <form method="POST" action="{{ route('fornecedores.update', $f->id) }}" class="p-6 space-y-6">
                                        @csrf
                                        @method('PUT')

                                        <h2 class="text-lg font-medium text-gray-900">Editar Fornecedor</h2>

                                        <!-- Tipo -->
                                        <div class="flex flex-col w-full mt-4">
                                            <x-custom-select
                                                name="tipo"
                                                :options="collect([
                                                    (object)['id' => 'CNPJ', 'nome' => 'CNPJ'],
                                                    (object)['id' => 'CPF', 'nome' => 'CPF']
                                                ])"
                                                label="Tipo de Fornecedor"
                                                placeholder="-- Selecione o tipo --"
                                                :selected="old('tipo')"
                                            />
                                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                                        </div>

                                        <!-- Razão Social -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="razao_social" :value="__('Razão Social')" class="w-full" />
                                            <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="old('razao_social', $f->razao_social)" required />
                                            <x-input-error :messages="$errors->get('razao_social')" class="mt-2" />
                                        </div>

                                        <!-- CNPJ/CPF -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="cnpj_cpf" :value="__('CNPJ/CPF')" class="w-full" />
                                            <x-text-input id="cnpj_cpf" class="block mt-1 w-full" type="text" name="cnpj_cpf" :value="old('cnpj_cpf', $f->cnpj_cpf)" required />
                                            <x-input-error :messages="$errors->get('cnpj_cpf')" class="mt-2" />
                                        </div>

                                        <!-- Email -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="email" :value="__('Email')" class="w-full" />
                                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $f->email)" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Telefone -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="telefone" :value="__('Telefone')" class="w-full" />
                                            <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone', $f->telefone)" />
                                            <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                                        </div>

                                        <!-- Endereço -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="endereco" :value="__('Endereço')" class="w-full" />
                                            <x-text-input id="endereco" class="block mt-1 w-full" type="text" name="endereco" :value="old('endereco', $f->endereco)" />
                                            <x-input-error :messages="$errors->get('endereco')" class="mt-2" />
                                        </div>

                                        <!-- Cidade -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="cidade" :value="__('Cidade')" class="w-full" />
                                            <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade', $f->cidade)" />
                                            <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
                                        </div>

                                        <!-- País -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="pais" :value="__('País')" class="w-full" />
                                            <x-text-input id="pais" class="block mt-1 w-full" type="text" name="pais" :value="old('pais', $f->pais)" />
                                            <x-input-error :messages="$errors->get('pais')" class="mt-2" />
                                        </div>

                                        <!-- CEP -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="cep" :value="__('CEP')" class="w-full" />
                                            <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" :value="old('cep', $f->cep)" />
                                            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
                                        </div>

                                        <!-- PIX -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="pix" :value="__('PIX')" class="w-full" />
                                            <x-text-input id="pix" class="block mt-1 w-full" type="text" name="pix" :value="old('pix', $f->pix)" />
                                            <x-input-error :messages="$errors->get('pix')" class="mt-2" />
                                        </div>

                                        <!-- Conta Corrente -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="conta_corrente" :value="__('Conta Corrente')" class="w-full" />
                                            <x-text-input id="conta_corrente" class="block mt-1 w-full" type="text" name="conta_corrente" :value="old('conta_corrente', $f->conta_corrente)" />
                                            <x-input-error :messages="$errors->get('conta_corrente')" class="mt-2" />
                                        </div>

                                        <!-- Agência -->
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="agencia" :value="__('Agência')" class="w-full" />
                                            <x-text-input id="agencia" class="block mt-1 w-full" type="text" name="agencia" :value="old('agencia', $f->agencia)" />
                                            <x-input-error :messages="$errors->get('agencia')" class="mt-2" />
                                        </div>

                                        <!-- Botões -->
                                        <div class="flex justify-end gap-4 mt-6">
                                            <x-secondary-button x-on:click="$dispatch('close')" type="button">Cancelar</x-secondary-button>
                                            <x-primary-button type="submit">Salvar</x-primary-button>
                                        </div>
                                    </form>

                                </x-modal>


                                <x-modal name="delete-fornecedor-{{ $f->id }}" focusable>
                                    <form method="POST" action="{{ route('fornecedores.destroy', $f->id) }}" class="p-6">
                                        @csrf
                                        @method('DELETE')
                                        <h2 class="text-lg font-medium text-gray-900">Excluir Fornecedor?</h2>
                                        <p class="mt-1 text-sm text-gray-600">Esta ação não pode ser desfeita.</p>
                                        <div class="mt-6 flex justify-end gap-3">
                                            <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                                            <x-danger-button>Excluir</x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-6 pr-6">
            <x-primary-button x-data="" x-on:click="window.location.href='{{ route('painel') }}'">
                Voltar
            </x-primary-button>
        </div>
    </div>

    <script>
        function filtrarTabela() {
            const table = document.getElementById("fornecedoresTable");
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
                        if (!txtValue.toLowerCase().includes(filtro)) visible = false;
                    }
                });
                rows[i].style.display = visible ? "" : "none";
            }
        }

        let sortDirection = {};
        function ordenarTabela(colIndex) {
            const table = document.getElementById("fornecedoresTable");
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