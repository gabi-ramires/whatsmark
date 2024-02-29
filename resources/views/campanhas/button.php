<?php

// URL do endpoint
$url = 'http://34.125.72.253:3000/client/sendMessage/a1d0c6e83f027327d8461063f4ac58a6';

// Dados para enviar
$data = array(
    'chatId' => '555180187026@c.us',
    'contentType' => 'Buttons',
    'content' => array(
        'body' => "Hello World!",
        'buttons' => array(
            array(
                'body' => "button 1"
            )
        ),
        "title" => "hello word",
        "footer" => "rodape"
    )
);

// Converte os dados para JSON
$data = json_encode($data);

// Configuração do cabeçalho
$headers = array(
    'accept: */*',
    'x-api-key: chavegabi',
    'Content-Type: application/json'
);

// Inicializa o cURL
$ch = curl_init();

// Configura as opções do cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Executa a solicitação
$response = curl_exec($ch);

// Verifica por erros
if(curl_errno($ch)){
    echo 'Erro ao enviar a solicitação: ' . curl_error($ch);
}

// Fecha a conexão cURL
curl_close($ch);

// Exibe a resposta
echo $response;
?>
