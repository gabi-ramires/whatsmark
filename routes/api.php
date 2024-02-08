<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/client/sendMessage/{sessionId}/{body}', [ApiController::class, 'sendMessage']);

class ApiController
{   
    public $uri;
    public $apiKey;

    public function __construct()
    {
        $this->uri = "http://34.125.239.151:3000/";
        $this->apiKey = 'comunidadezdg.com.br';
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

    public function sendMessage($sessionId, $data='nada')
    {   
        $url = $this->uri."client/sendMessage/{$sessionId}";
    
        $headers = array(
            'Accept: */*',
            'x-api-key: ' . $this->apiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $response;
    }
    
}
