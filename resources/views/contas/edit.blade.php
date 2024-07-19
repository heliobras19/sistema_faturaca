<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário') }}
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
                    <form action="{{ route('contas.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" name="name" id="name" class="form-input mt-1 block w-full" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="form-input mt-1 block w-full" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Senha (deixe em branco para manter a atual)</label>
                                <input type="password" name="password" id="password" class="form-input mt-1 block w-full">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirme a Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input mt-1 block w-full">
                            </div>
                            <div>
                                <label for="is_admin" class="block text-sm font-medium text-gray-700">Admin</label>
                                <select name="is_admin" id="is_admin" class="form-select mt-1 block w-full">
                                    <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Sim</option>
                                </select>
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
</x-app-layout>
