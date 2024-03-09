<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    public function verificaSeTemPlano($sessionId)
    {
        $userId = $this->getUserIdBySessionId($sessionId);

        $response = DB::table('contratos')
        ->where('user_id', $userId)
        ->exists();

        if (!$response) {
            $resposta = array('success' => false, 'message' => 'Não possui plano contrato.');

            return $resposta;            
        }

        $resposta = array('success' => true, 'message' => 'Tem plano contratado.');

        return $resposta;    
    }

    public function getUserIdBySessionId($sessionId)
    {
        $userId = DB::table('setupWhats')
        ->where('IdSession', $sessionId)
        ->value('idUser');

        if (!$userId) {
            $resposta = array('success' => false, 'message' => 'Não foi encontrado esse cliente.');

            return $resposta;            
        }

        return $userId;
    }
}
