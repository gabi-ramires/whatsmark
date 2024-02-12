<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\SetupWhats;

class SetupWhatsController extends Controller
{
    public function getIdSession()
    {
        // Recuperar o ID do usuário autenticado
        $userId = Auth::id();

        // Recuperar o registro da tabela SetupWhats com base no IdUser
        $setup = SetupWhats::where('IdUser', $userId)->first();

        // Verificar se o registro existe e obter o IdSession
        $idSession = $setup ? $setup->IdSession : '';

        // Passar o IdSession para a view
        return view('painel/tutorial', ['idSession' => $idSession]);
    }
}
