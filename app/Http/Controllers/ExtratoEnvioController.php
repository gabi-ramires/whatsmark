<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtratoEnvios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExtratoEnvioController extends Controller
{
    public function index()
    {
        // Exibe todos os envios
        $envios = ExtratoEnvios::all();
        return response()->json($envios);
    }

    public function storeExtratoEnvios(Request $request)
    {
        // Valida os dados recebidos do request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'limite' => 'required|integer',
            'creditos' => 'required|integer',
            'envios' => 'required|integer'
        ]);

        // Cria um novo registro de extrato de envios
        $extratoEnvios = ExtratoEnvios::create($request->all());

        return response()->json($extratoEnvios, 201);
    }

    public function show($id)
    {
        // Exibe um envio específico
        $envio = ExtratoEnvios::findOrFail($id);
        return response()->json($envio);
    }

    public function update(Request $request, $id)
    {
        // Atualiza um envio existente
        $envio = ExtratoEnvios::findOrFail($id);
        $envio->update($request->all());
        return response()->json($envio, 200);
    }

    public function destroy($id)
    {
        // Exclui um envio existente
        $envio = ExtratoEnvios::findOrFail($id);
        $envio->delete();
        return response()->json(null, 204);
    }

    public function getSaldo()
    {
        $userId = Auth::id();

        $saldo = DB::table('extrato_envios')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->value('saldo');

        return $saldo;
    }

    public function getLimite()
    {
        $userId = Auth::id();

        $plano_id = DB::table('contratos')
        ->where('user_id', $userId)
        ->value('plano_id');

        $limite = DB::table('planos')
        ->where('id', $plano_id)
        ->value('limite_envios');


        return $limite;
    }

}
