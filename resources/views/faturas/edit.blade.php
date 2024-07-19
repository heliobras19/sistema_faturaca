<!-- resources/views/faturas/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Fatura') }}
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
                    <form action="{{ route('faturas.update', $fatura->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="numero_fatura" class="block text-sm font-medium text-gray-700">Número da Fatura</label>
                                <input type="text" name="numero_fatura" readonly id="numero_fatura" class="form-input mt-1 block w-full" value="{{ old('numero_fatura', $fatura->numero_fatura) }}" required>
                            </div>
                            <div>
                                <label for="data_emissao" class="block text-sm font-medium text-gray-700">Data de Emissão</label>
                                <input type="date" name="data_emissao" readonly id="data_emissao" class="form-input mt-1 block w-full" value="{{ old('data_emissao', $fatura->data_emissao) }}" required>
                            </div>
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="estado" id="tipo" class="mt-1 block w-full">
                                    <option value="">Selecione o estado</option>
                                    <option value="Paga" {{ old('estado', $fatura->estado) == 'Paga' ? 'selected' : '' }}>Paga</option>
                                    <option value="Não Paga" {{ old('estado', $fatura->estado) == 'Não Paga' ? 'selected' : '' }}>Não Paga</option>
                                </select>
                            </div>
                            <div>
                                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                                <select name="cliente_id" readonly id="cliente_id" class="form-select mt-1 block w-full" required>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ $cliente->id == $fatura->cliente_id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="itens-container">
                                <label for="itens" class="block text-sm font-medium text-gray-700">Itens</label>
                                @foreach ($fatura->itens as $index => $item)
                                    <div class="flex items-center mb-4">
                                        <select name="itens[{{ $index }}][produto_id]" class="form-select mt-1 block w-full mr-4" required>
                                            @foreach ($produtos as $produto)
                                                <option value="{{ $produto->id }}" {{ $produto->id == $item->produto_id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
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
        document.addEventListener('DOMContentLoaded', () => {
            let itemIndex = {{ $fatura->itens->count() }};
            const itensContainer = document.getElementById('itens-container');

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.target.closest('.flex').remove();
                });
            });

            document.querySelector('.add-item').addEventListener('click', () => {
                const newItem = document.createElement('div');
                newItem.classList.add('flex', 'items-center', 'mb-4');
                newItem.innerHTML = `
                    <select name="itens[${itemIndex}][produto_id]" class="form-select mt-1 block w-full mr-4" required>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="itens[${itemIndex}][quantidade]" class="form-input mt-1 block w-24 mr-4" value="1" required>
                    <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">-</button>
                `;
                itensContainer.appendChild(newItem);
                itemIndex++;

                newItem.querySelector('.remove-item').addEventListener('click', () => {
                    newItem.remove();
                });
            });
        });
    </script>
</x-app-layout>
