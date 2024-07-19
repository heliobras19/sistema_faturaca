<!-- resources/views/clientes/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <strong>Nome:</strong>
                        {{ $cliente->nome }}
                    </div>
                    <div>
                        <strong>Endereço:</strong>
                        {{ $cliente->endereco }}
                    </div>
                    <div>
                        <strong>NIF:</strong>
                        {{ $cliente->nif }}
                    </div>
                    <div>
                        <strong>Telefone:</strong>
                        {{ $cliente->telefone }}
                    </div>
                    <div>
                        <strong>Email:</strong>
                        {{ $cliente->email }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
