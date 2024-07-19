<!-- resources/views/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Gráfico Produtos Mais Faturados -->
                        <div>
                            <canvas id="produtosChart"></canvas>
                        </div>
                        <!-- Gráfico Clientes Que Mais Compram -->
                        <div>
                            <canvas id="clientesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicione o Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Dados para o gráfico de produtos mais faturados
            const produtosData = @json($produtos->map(function($produto) {
                return [
                    'nome' => $produto->nome,
                    'faturas_count' => $produto->faturas_count
                ];
            }));

            const produtosLabels = produtosData.map(data => data.nome);
            const produtosValues = produtosData.map(data => data.faturas_count);

            new Chart(document.getElementById('produtosChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: produtosLabels,
                    datasets: [{
                        label: 'Produtos Mais Faturados',
                        data: produtosValues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Dados para o gráfico de clientes que mais compram
            const clientesData = @json($clientes->map(function($cliente) {
                return [
                    'nome' => $cliente->nome,
                    'faturas_count' => $cliente->faturas_count
                ];
            }));

            const clientesLabels = clientesData.map(data => data.nome);
            const clientesValues = clientesData.map(data => data.faturas_count);

            new Chart(document.getElementById('clientesChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: clientesLabels,
                    datasets: [{
                        label: 'Clientes Que Mais Compram',
                        data: clientesValues,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
