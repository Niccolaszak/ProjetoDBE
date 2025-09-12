<x-aviso type="success" :message="session('success')" />
<x-aviso type="error" :message="session('error')" />

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Consultar Estoque
            </h2>
        </div>
    </x-slot>


    <div class="overflow-x-auto p-6">
        <table class="w-full border border-gray-300 bg-white rounded-lg shadow-md" id="setoresTable">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(0)">
                        Livro ⬍ <br>
                        <input id="filtro-livro" type="text" onkeyup="filtrarTabela()" data-col="0" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Livro...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(1)">
                        Quantidade Disponível ⬍ <br>
                        <input id="filtro-disponivel" type="text" onkeyup="filtrarTabela()" data-col="1" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Quantidade Disponível...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(2)">
                        Quantidade Consumida ⬍ <br>
                        <input id="filtro-consumida" type="text" onkeyup="filtrarTabela()" data-col="2" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Quantidade Consumida...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(3)">
                        Total Movimentado ⬍ <br>
                        <input id="filtro-movimentada" type="text" onkeyup="filtrarTabela()" data-col="3" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Total Movimentado...">
                    </th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 cursor-pointer" onclick="ordenarTabela(4)">
                        Última Movimentação ⬍ <br>
                        <input id="filtro-hist" type="text" onkeyup="filtrarTabela()" data-col="4" class="mt-1 p-1 border rounded w-full text-sm" placeholder="Filtrar Última Movimentação...">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($estoques as $estoque)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $estoque->livro->titulo }}</td>
                        <td class="px-4 py-2">{{ $estoque->quantidade_disponivel }}</td>
                        <td class="px-4 py-2">{{ $estoque->quantidade_consumida }}</td>
                        <td class="px-4 py-2">{{ $estoque->quantidade_disponivel + $estoque->quantidade_consumida }}</td>
                        <td class="px-4 py-2">{{ $estoque->ultima_movimentacao }}</td>
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
            const table = document.getElementById("setoresTable");
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
            const table = document.getElementById("setoresTable");
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