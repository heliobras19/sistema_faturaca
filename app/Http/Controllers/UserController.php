<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
       // Mostra a lista de usuários
    public function index()
    {
        $users = User::all();
        return view('contas.index', compact('users'));
    }

    // Mostra o formulário para criar um novo usuário
    public function create()
    {
        return view('contas.create');
    }

    // Armazena um novo usuário no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => $validatedData['is_admin'],
        ]);

        return redirect()->route('contas.index')->with('success', 'Usuário criado com sucesso!');
    }

    // Mostra detalhes de um usuário específico
    public function show(User $user)
    {
        return view('contas.show', compact('user'));
    }

    // Mostra o formulário para editar um usuário existente
    public function edit(User $user)
    {
        return view('contas.edit', compact('user'));
    }

    // Atualiza um usuário existente no banco de dados
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            'is_admin' => $validatedData['is_admin'],
        ]);

        return redirect()->route('contas.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Remove um usuário existente do banco de dados
    public function destroy(int $user)
    {
        $user = User::find($user);
        $user->delete();
        return redirect()->route('contas.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
