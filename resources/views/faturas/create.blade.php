<!-- resources/views/faturas/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Nova Fatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Há alguns problemas com a sua entrada.</span>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('faturas.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="numero_fatura" class="block text-sm font-medium text-gray-700">Número da Fatura</label>
                                <input type="text" name="numero_fatura" id="numero_fatura" class="form-input mt-1 block w-full" value="" readonly>
                            </div>
                            <div>
                                <label for="data_emissao" class="block text-sm font-medium text-gray-700">Data de Emissão</label>
                                <input type="date" name="data_emissao" id="data_emissao" class="form-input mt-1 block w-full" value="{{ old('data_emissao') }}" required>
                            </div>
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="estado" id="estado" class="mt-1 block w-full">
                                    <option value="">Selecione o estado</option>
                                    <option value="Paga" {{ old('estado') == 'Paga' ? 'selected' : '' }}>Paga</option>
                                    <option value="Não Paga" {{ old('estado') == 'Não Paga' ? 'selected' : '' }}>Não Paga</option>
                                </select>
                            </div>
                            <div>
                                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select mt-1 block w-full" required>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="itens-container">
                                <label for="itens" class="block text-sm font-medium text-gray-700">Itens</label>
                                <div class="flex items-center mb-4">
                                    <select name="itens[0][produto_id]" class="form-select mt-1 block w-full mr-4" required>
                                        @foreach ($produtos as $produto)
                                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">{{ $produto->nome }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="itens[0][quantidade]" class="form-input mt-1 block w-24 mr-4" value="1" min="1" required>
                                    <button type="button" class="add-item bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="border-t border-gray-300 pt-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total:</span>
                                    <span id="total-amount">AOA 0.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Salvar') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para gerar um UUID
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Gerar UUID e definir o valor do campo
            document.getElementById('numero_fatura').value = generateUUID();

            let itemIndex = 1;
            const itensContainer = document.getElementById('itens-container');
            const totalAmountElement = document.getElementById('total-amount');

            function calculateTotal() {
                let total = 0;
                const items = itensContainer.querySelectorAll('div.flex');
                items.forEach(item => {
                    const quantity = parseFloat(item.querySelector('input[name*="quantidade"]').value) || 0;
                    const price = parseFloat(item.querySelector('select[name*="produto_id"] option:checked').dataset.preco) || 0;
                    total += quantity * price;
                });
                totalAmountElement.textContent = `AOA ${total.toFixed(2)}`;
            }

            document.querySelector('.add-item').addEventListener('click', () => {
                const newItem = document.createElement('div');
                newItem.classList.add('flex', 'items-center', 'mb-4');
                newItem.innerHTML = `
                    <select name="itens[${itemIndex}][produto_id]" class="form-select mt-1 block w-full mr-4" required>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="itens[${itemIndex}][quantidade]" class="form-input mt-1 block w-24 mr-4" value="1" min="1" required>
                    <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">-</button>
                `;
                itensContainer.appendChild(newItem);
                itemIndex++;

                newItem.querySelector('.remove-item').addEventListener('click', () => {
                    newItem.remove();
                    calculateTotal();
                });

                newItem.querySelector('select').addEventListener('change', calculateTotal);
                newItem.querySelector('input').addEventListener('input', calculateTotal);

                calculateTotal();
            });

            document.querySelectorAll('select, input').forEach(element => {
                element.addEventListener('change', calculateTotal);
            });

            calculateTotal();
        });
    </script>
</x-app-layout>
