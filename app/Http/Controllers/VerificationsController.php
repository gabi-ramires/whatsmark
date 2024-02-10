<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerificationsController extends Controller
{
    public function verifyIfEmailAlreadyExist(Request $request)
    {   
        $email = $request['email'];

        $user = User::where('email', $email)->first();

        if ($user) {
            // O email já existe no banco de dados
            return response()->json(['message' => 'Email já existe'], 409);
        } else {
            // O email não existe no banco de dados
            return response()->json(['message' => 'Email disponível'], 200);
        }
    }
}