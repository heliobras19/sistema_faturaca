<!-- resources/views/produtos/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong>Ops!</strong> Há algo errado com seus dados.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" name="nome" id="nome" class="mt-1 block w-full" value="{{ $produto->nome }}">
                            </div>
                            <div>
                                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea name="descricao" id="descricao" class="mt-1 block w-full">{{ $produto->descricao }}</textarea>
                            </div>
                            <div>
                                <label for="preco" class="block text-sm font-medium text-gray-700">Preço</label>
                                <input type="text" name="preco" id="preco" class="mt-1 block w-full" value="{{ $produto->preco }}">
                            </div>
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="tipo" id="tipo" class="mt-1 block w-full">
                                    <option value="">Selecione o tipo</option>
                                    <option value="produto" {{ $produto->tipo == 'produto' ? 'selected' : '' }}>Produto</option>
                                    <option value="servico" {{ $produto->tipo == 'servico' ? 'selected' : '' }}>Serviço</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
