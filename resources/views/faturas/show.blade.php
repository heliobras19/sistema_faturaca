<!-- resources/views/faturas/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Fatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-xl font-bold mb-4">
                        Detalhes da Fatura
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Número da Fatura:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->numero_fatura }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Data de Emissão:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->data_emissao }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Cliente:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->cliente->nome }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Valor Total:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->valor_total }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Impostos:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->impostos }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Estado:</div>
                            <div class="text-lg text-gray-900">{{ $fatura->estado }}</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="text-sm font-medium text-gray-700">Itens:</div>
                            <ul class="list-disc pl-5 mt-2 text-gray-900">
                                @foreach ($fatura->itens as $item)
                                    <li>{{ $item->produto->nome }} - Quantidade: {{ $item->quantidade }} - Preço Unitário: {{ $item->preco_unitario }} - Valor Total: {{ $item->valor_total }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('faturas.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg shadow-sm hover:bg-gray-700 transition duration-300">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
