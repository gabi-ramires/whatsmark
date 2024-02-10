<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Criação de um novo usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Retorna uma resposta adequada
        return response()->json(['message' => 'User registered successfully'], 201);
    }


    public function login(Request $request)
    {  
        // Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentativa de autenticação do usuário
        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            return response()->json(['message' => 'Login successful', 'redirect' => '/painel'], 200);
        } else {
            // Autenticação falhou
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}