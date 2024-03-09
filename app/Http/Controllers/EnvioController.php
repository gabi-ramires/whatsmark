<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExtratoEnvioController;

class EnvioController extends Controller
{
    public function index()
    {
        // Exibe todos os envios
        $envios = Envio::all();
        return response()->json($envios);
    }

    /**
     * Loga em 'envios' e 'extrato_envios'
     */
    public function storeEnvios(Request $request)
    { 
        // Obtém o ID do usuário autenticado
        $userId = Auth::id();


        //Envios
        $contacts = DB::table('lists')
                ->where('id', $request->input('lista_enviada'))
                ->value('contacts');
        $contatos = json_decode($contacts);
        $envios = count($contatos);

        //Saldo
        $saldo = DB::table('extrato_envios')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->value('saldo');

        // Criando um novo objeto Request com os dados necessários
        $requestExtrato = new Request([
            'user_id' => $userId,
            'limite' => 1000,
            'creditos' => 0,
            'envios' => $envios,
            'saldo'=> $saldo - $envios,
            'motivo' => ""
        ]);

        // Loga o envio
        $envio = new Envio();
        $envio->user_id = $userId;
        $envio->mensagem_enviada = $request->input('mensagem_enviada');
        $envio->titulo = $request->input('titulo');
        $envio->lista_enviada = $request->input('lista_enviada');
        $envio->tipo_envio = $request->input('tipo_envio');
        $envio->horario_envio = $request->input('horario_envio');
        $envio->save();

        // Loga no extrato de envios
        $extrato = new ExtratoEnvioController();
        $extrato->storeExtratoEnvios($requestExtrato);
    }

    public function show($id)
    {
        // Exibe um envio específico
        $envio = Envio::findOrFail($id);
        return response()->json($envio);
    }

    public function update(Request $request, $id)
    {
        // Atualiza um envio existente
        $envio = Envio::findOrFail($id);
        $envio->update($request->all());
        return response()->json($envio, 200);
    }

    public function destroy($id)
    {
        // Exclui um envio existente
        $envio = Envio::findOrFail($id);
        $envio->delete();
        return response()->json(null, 204);
    }

    public function getTodosEnvios()
    {
        // Obtém todos os envios da tabela
        $envios = Envio::all();

        // Retorna os envios obtidos
        return $envios;
    }

}
