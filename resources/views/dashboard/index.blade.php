<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex gap-6 h-[300px]">
                <!-- Coluna esquerda: 4 cards -->
                <div class="w-2/3 grid grid-cols-2 gap-6 h-full">
                    <!-- Card 1 -->
                    <div class="bg-green-100 rounded-lg shadow p-4 flex items-center space-x-4">
                        <div class="text-green-600">
                            <!-- Ícone -->
                        </div>
                        <div>
                            <p class="text-gray-700 font-medium">Total Disponível</p>
                            <p class="text-2xl font-bold">{{ $estoque->quantidade_disponivel }}</p>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-red-100 rounded-lg shadow p-4 flex items-center space-x-4">
                        <div class="text-red-600"></div>
                        <div>
                            <p class="text-gray-700 font-medium">Total Consumido</p>
                            <p class="text-2xl font-bold">{{ $estoque->quantidade_consumida }}</p>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-blue-100 rounded-lg shadow p-4 flex items-center space-x-4">
                        <div class="text-blue-600"></div>
                        <div>
                            <p class="text-gray-700 font-medium">Movimentações Totais</p>
                            <p class="text-2xl font-bold">{{ $totalMovimentacoes }}</p>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-yellow-100 rounded-lg shadow p-4 flex items-center space-x-4">
                        <div class="text-yellow-600"></div>
                        <div>
                            <p class="text-gray-700 font-medium">Total de Livros</p>
                            <p class="text-2xl font-bold">{{ $totalLivros }}</p>
                        </div>
                    </div>
                </div>

                <!-- Coluna direita: Gráfico de pizza -->
                <div class="w-1/3 flex items-center justify-center h-full">
                    <div class="bg-white shadow rounded-lg p-4 w-64">
                        <h3 class="text-sm font-semibold mb-2 text-center">Proporção do Estoque</h3>
                        <canvas id="estoqueChart" height="150" width="150"></canvas>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Movimentações (Barras) -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Movimentações Mensais</h3>
                <canvas id="movimentacoesChart" height="100"></canvas>
            </div>

            <!-- Gráfico de Estoque por Livro -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Estoque por Livro</h3>
                <canvas id="estoqueLivroChart" height="100"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Movimentações
        const ctxMov = document.getElementById('movimentacoesChart').getContext('2d');
        new Chart(ctxMov, {
            type: 'bar',
            data: {
                labels: {!! json_encode($movimentacoesLabels) !!},
                datasets: [
                    {
                        label: 'Entradas',
                        data: {!! json_encode($movimentacoesEntradas) !!},
                        backgroundColor: 'rgba(34,197,94,0.7)',
                    },
                    {
                        label: 'Saídas',
                        data: {!! json_encode($movimentacoesSaidas) !!},
                        backgroundColor: 'rgba(239,68,68,0.7)',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Gráfico de Estoque por Livro
        const ctxLivro = document.getElementById('estoqueLivroChart').getContext('2d');
        new Chart(ctxLivro, {
            type: 'bar',
            data: {
                labels: {!! json_encode($livrosLabels) !!},
                datasets: [{
                    label: 'Disponível',
                    data: {!! json_encode($livrosDisponiveis) !!},
                    backgroundColor: 'rgba(59,130,246,0.7)',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Gráfico de Proporção (Pizza)
        const ctxEst = document.getElementById('estoqueChart').getContext('2d');
        new Chart(ctxEst, {
            type: 'doughnut',
            data: {
                labels: ['Disponível', 'Consumido'],
                datasets: [{
                    data: [{{ $estoque->quantidade_disponivel }}, {{ $estoque->quantidade_consumida }}],
                    backgroundColor: ['rgba(34,197,94,0.7)', 'rgba(239,68,68,0.7)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
    @endpush
</x-app-layout>