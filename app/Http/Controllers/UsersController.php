<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SetupWhats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        return response()->json(['success' => true, 'message' => 'User registered successfully'], 201);
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
            return response()->json(['success' => true, 'message' => 'Login successful'], 200);
        } else {
            // Autenticação falhou
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect('/login');
    }

    public function geraIdSession($idUser)
    {
        $idSession = md5($idUser);

        return $idSession;
    }

    public function updatePassword(Request $request)
    {
        // Criptografa a senha nova
        $senhaNova = $request->senhaNova;
        $senhaNovaCript = bcrypt($senhaNova);
    
        // Busca senha atual do banco
        $user = Auth::user();
        $senhaAtualDBCript = $user->password;
    
        // Verifica se a senha atual informada confere com a do banco
        if (!Hash::check($request->senhaAtual, $senhaAtualDBCript)) {
            return response()->json(['success' => false, 'message' => 'Senha atual não confere'], 200);
        }
    
        // Atualiza a senha no banco de dados
        $user->password = $senhaNovaCript;
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'Senha atualizada com sucesso']);
    }
    
}