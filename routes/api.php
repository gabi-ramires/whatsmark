<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\CronController;
use App\Http\Controllers\SetupWhatsController;

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
        $cron = new CronController();

        $msg = $request->content;
        $contatos = $request->lista;
        $data = $request->data;

        // Extrai a hora e os minutos da string
        list($ano, $mes, $dia, $hora, $minuto) = sscanf($data, "%d-%d-%dT%d:%d");

        $contatos = json_decode($contatos);

        //$comando = 'crontab -l | { cat; echo "43 16 * * * /var/www/html/sendMessageAgendado.sh \"'.$sessionId.'\" \"'.$msg.'\" "; } | crontab -';

        $comando = 'crontab -l | { cat; echo "'.$minuto.' '.$hora.' '.$dia.' '.$mes.' * php /var/www/html/sendMessageAgendado.php \"'.$sessionId.'\" \"'.$msg.'\" \"'.$contatos.'\" "; } | crontab -';

        $res = $cron->cron($comando);

        return response()->json(['status' => true, 'message' => "Envio agendado com sucesso"]);
        
    }

}
