<!-- resources/views/clientes/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ops!</strong> Há algo errado com seus dados.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" name="nome" id="nome" class="mt-1 block w-full" value="{{ $cliente->nome }}">
                            </div>
                            <div>
                                <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                                <input type="text" name="endereco" id="endereco" class="mt-1 block w-full" value="{{ $cliente->endereco }}">
                            </div>
                            <div>
                                <label for="nif" class="block text-sm font-medium text-gray-700">NIF</label>
                                <input type="text" name="nif" id="nif" class="mt-1 block w-full" value="{{ $cliente->nif }}">
                            </div>
                            <div>
                                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="mt-1 block w-full" value="{{ $cliente->telefone }}">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ $cliente->email }}">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
