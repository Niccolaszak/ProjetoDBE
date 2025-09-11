<!-- resources/views/dashboard/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Cards de Estoque -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-green-100 rounded-lg shadow p-6 flex items-center space-x-4">
                    <div class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium">Disponível</p>
                        <p class="text-2xl font-bold">{{ $estoque->quantidade_disponivel }}</p>
                    </div>
                </div>

                <div class="bg-red-100 rounded-lg shadow p-6 flex items-center space-x-4">
                    <div class="text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium">Consumido</p>
                        <p class="text-2xl font-bold">{{ $estoque->quantidade_consumida }}</p>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Movimentações (Barras) -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Movimentações Mensais</h3>
                <canvas id="movimentacoesChart" height="100"></canvas>
            </div>

            <!-- Gráfico de Estoque (Pizza) -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Proporção do Estoque</h3>
                <canvas id="estoqueChart" height="100"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Movimentações
        const ctxMov = document.getElementById('movimentacoesChart').getContext('2d');
        const movimentacoesChart = new Chart(ctxMov, {
            type: 'bar',
            data: {
                labels: {!! json_encode($movimentacoesLabels) !!},
                datasets: [
                    {
                        label: 'Entradas',
                        data: {!! json_encode($movimentacoesEntradas) !!},
                        backgroundColor: 'rgba(34,197,94,0.7)',
                        borderRadius: 5,
                    },
                    {
                        label: 'Saídas',
                        data: {!! json_encode($movimentacoesSaidas) !!},
                        backgroundColor: 'rgba(239,68,68,0.7)',
                        borderRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { stacked: false },
                    y: { beginAtZero: true }
                }
            }
        });

        // Gráfico de Estoque (Pizza)
        const ctxEst = document.getElementById('estoqueChart').getContext('2d');
        const estoqueChart = new Chart(ctxEst, {
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
                plugins: {
                    legend: { position: 'bottom' },
                }
            }
        });
    </script>
    @endpush
</x-app-layout>