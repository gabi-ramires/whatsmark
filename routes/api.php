<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\CronController;
use App\Http\Controllers\SetupWhatsController;
use App\Http\Controllers\EnvioController;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/session/start/{sessionId}', [ApiController::class, 'startNewSession']);
Route::get('/session/status/{sessionId}', [ApiController::class, 'getStatusSession']);
Route::get('/session/qr/{sessionId}/image', [ApiController::class, 'carregaQrCode']);
Route::post('/client/sendMessage/{sessionId}', [ApiController::class, 'sendMessage']);
Route::post('/client/sendMessageAgendado/{sessionId}', [ApiController::class, 'sendMessageAgendado']);
Route::post('/client/sendCampanha/{sessionId}', [ApiController::class, 'sendCampanha']);



class ApiController
{   
    public $uri;
    public $apiKey;

    public function __construct()
    {   
        $this->uri = "http://34.125.146.115:3000/";
        $this->apiKey = 'chavegabi';

    }
    
    public function startNewSession($sessionId)
    {
        $url = $this->uri."session/start/{$sessionId}";

        $headers = array(
            'accept: application/json',
            'x-api-key: ' . $this->apiKey
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $response;
    }

    public function getStatusSession($sessionId)
    {
        $url = $this->uri."session/status/{$sessionId}";

        $headers = array(
            'accept: application/json',
            'x-api-key: ' . $this->apiKey
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $response;
    }

    public function carregaQrCode($sessionId)
    {
        $url = $this->uri."session/qr/{$sessionId}/image";
    
        $headers = array(
            'accept: image/png', // Aceitar uma resposta de imagem PNG
            'x-api-key: ' . $this->apiKey
        );
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $imageData = curl_exec($ch); // Aqui a imagem é retornada como dados binários
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        curl_close($ch);
    
        // Retorne os dados da imagem em vez da resposta
        return $imageData;
    }

    public function sendMessage($sessionId, Request $request)
    {   
        $url = $this->uri."client/sendMessage/{$sessionId}";
    
        // Obter os parâmetros do pedido
        $chatId = $request->request->get('chatId');
        $msg = $request->request->get('content');
    
        // Construir o corpo da solicitação como um objeto JSON
        $requestData = json_encode(array(
            'chatId' => $chatId,
            'content' => $msg,
            "contentType" => "string"
        ));
    
        $headers = array(
            'Accept: */*',
            'x-api-key:' . $this->apiKey,
            'Content-Type: application/json'
        );
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData); // Passar os dados convertidos para JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        curl_close($ch);
    
        return $response;
    }

    public function sendMessageAgendado($sessionId, Request $request)
    { 

        $msg = $request->content;
        $contatos = $request->lista;
        $data = $request->data;
        $titulo = $request->titulo;
        $lista_enviada = $request->id_lista;
        $tipo_envio = 'agendado';
        $horario_envio = $request->data;

        // Extrai a hora e os minutos da string
        list($ano, $mes, $dia, $hora, $minuto) = sscanf($data, "%d-%d-%dT%d:%d");

        $contatos = json_decode($contatos);

        //verifica se tem saldo suficiente
        $temSaldo = $this->verificaSeTemSaldo(count(json_decode($contatos)), $sessionId);

        if (!$temSaldo){
            $response = array('success' => false, 'message' => 'Não possui saldo suficiente');
            return json_encode($response);
        }

        $comando = 'crontab -l | { cat; echo "'.$minuto.' '.$hora.' '.$dia.' '.$mes.' * php /var/www/html/sendMessageAgendado.php \"'.$sessionId.'\" \"'.$msg.'\" \"'.$contatos.'\" "; } | crontab -';

        $cron = new CronController();
        $res = $cron->cron($comando);

        if(!$res['status']) {
            return response()->json(['status' => false, 'message' => "Erro ao agendar o envio."]);
        }

        // Preparando para logar
        $requestExtrato = new Request([
            'mensagem_enviada' => $msg,
            'titulo' => $titulo,
            'lista_enviada' => $lista_enviada,
            'tipo_envio' => $tipo_envio,
            'horario_envio'=> $horario_envio,
            'sessionId' => $sessionId
        ]);

        // Logando 'envios' e 'extrato-envios'
        $log = new EnvioController();
        $log->storeEnvios($requestExtrato);

        return response()->json(['status' => true, 'message' => "Envio agendado com sucesso"]);
        
    }

    public function sendCampanha($sessionId, Request $request)
    {   
        $url = $this->uri."client/sendMessage/{$sessionId}";

        $mensagem_enviada = $request->get('content');
        $titulo = $request->get('titulo');
        $lista_enviada = $request->input('id_lista');
        $tipo_envio = $request->input('tipo_envio');
        $horario_envio = $request->input('horario_envio');
    
        // Obter os parâmetros do pedido
        $contatos = $request->request->get('contatos');
        $msg = $request->request->get('content');

        $contatos = json_decode($contatos);

        //verifica se tem saldo suficiente
        $temSaldo = $this->verificaSeTemSaldo(count($contatos), $sessionId);

        if (!$temSaldo){
            $response = array('success' => false, 'message' => 'Não possui saldo suficiente');
            return json_encode($response);
        }

        $phone = "";
        foreach ($contatos as $key => $contato) {
            $phone = $contato->whatsapp;

            // Construir o corpo da solicitação como um objeto JSON
            $requestData = json_encode(array(
                'chatId' => $phone.'@c.us',
                'content' => $msg,
                "contentType" => "string"
            ));
        
            $headers = array(
                'Accept: */*',
                'x-api-key:' . $this->apiKey,
                'Content-Type: application/json'
            );
        
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData); // Passar os dados convertidos para JSON
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            curl_close($ch);

        }
        
        // Não foi realizado o envio
        if(!$response->success) {
            return $response;
        }

        // Preparando para logar
        $requestExtrato = new Request([
            'mensagem_enviada' => $mensagem_enviada,
            'titulo' => $titulo,
            'lista_enviada' => $lista_enviada,
            'tipo_envio' => $tipo_envio,
            'horario_envio'=> $horario_envio,
            'sessionId' => $sessionId
        ]);

        // Logando 'envios' e 'extrato-envios'
        $log = new EnvioController();
        $log->storeEnvios($requestExtrato);

        return $response;
    }

    public function verificaSeTemSaldo($envios, $sessionId)
    {   
        $userId = $this->getUserIdBySessionId($sessionId);

        $saldo = DB::table('extrato_envios')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->value('saldo');

        return ($saldo >= $envios);

    }

    public function getUserIdBySessionId($sessionId)
    {
        $userId = DB::table('setupWhats')
        ->where('IdSession', $sessionId)
        ->value('idUser');

        return $userId;
    }
}
