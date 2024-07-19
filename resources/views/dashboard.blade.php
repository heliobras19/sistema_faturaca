<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatorio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <!-- Filtros de Data -->
                    <form method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data Início</label>
                                <input type="date" id="data_inicio" name="data_inicio" class="form-input mt-1 block w-full" value="{{ request('data_inicio') }}">
                            </div>
                            <div>
                                <label for="data_fim" class="block text-sm font-medium text-gray-700">Data Fim</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-input mt-1 block w-full" value="{{ request('data_fim') }}">
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Filtrar') }}
                            </x-button>
                        </div>
                    </form>
                        <a href="/" class="btn btn-primary">Remover filtro</a>

                    <!-- Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800">Total de Vendas</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalVendas, 2, ',', '.') }} AOA</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800">Total de Impostos</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalImpostos, 2, ',', '.') }} AOA</p>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Gráfico de Produtos Mais Faturados -->
                        <div>
                            <canvas id="produtosChart"></canvas>
                        </div>

                        <!-- Gráfico de Clientes que Mais Compram -->
                        <div>
                            <canvas id="clientesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const produtosCtx = document.getElementById('produtosChart').getContext('2d');
            const clientesCtx = document.getElementById('clientesChart').getContext('2d');

            new Chart(produtosCtx, {
                type: 'bar',
                data: {
                    labels: @json($produtos->pluck('nome')),
                    datasets: [{
                        label: 'Vendas',
                        data: @json($produtos->pluck('itens_fatura_count')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(clientesCtx, {
                type: 'bar',
                data: {
                    labels: @json($clientes->pluck('nome')),
                    datasets: [{
                        label: 'Faturas',
                        data: @json($clientes->pluck('faturas_count')),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
