<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\SetupWhats;
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

        // Validação se as senhas são iguais
        $password = $request['password'];
        $repeatPassword = $request['repeatPassword'];
        if($password != $repeatPassword) {
            return response()->json(['message' => 'Passwords are different'], 409);
        }


        // Criação de um novo usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Alimentar a tabela "setupWhats"
        SetupWhats::create([
            'IdUser' => $user->id,
            'IdSession' => $this->geraIdSession($user->id)
        ]);

        // Autenticação do usuário recém-criado
        Auth::login($user);

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

    public function logout()
    {
        Auth::logout();
        
        return redirect('/');
    }

    public function geraIdSession($idUser){
        $idSession = md5($idUser);

        return $idSession;
    }
}