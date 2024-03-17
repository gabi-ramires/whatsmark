<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ContratarController extends Controller
{
    public function index()
    {
        // Exibe todos os envios
        $envios = Envio::all();
        return response()->json($envios);
    }

    public function pedido(Request $request)
    {   
        //Colocando cpf no banco
        $userId = Auth::id();
        $user = User::find($userId);
        if(!$user) {
            return array("success" => false, "message" => "Usuário não encontrado");
        }

        $user->cpf = $request->cpf;
        $user->save();

        //Buscando dados do produto
        $plano = DB::table('planos')
        ->where('slug', $request->slug)
        ->get();

        //gerar pagamento pix
        $response = $this->gerarPagamentoPix($user, $plano[0]);
        $response = json_decode($response);


        if(isset($response->error)){
            return array("success" => false, "message" => "Erro ao realizar o pedido", "erro" => $response->error);
        }

        $qr_code_64 = $response->point_of_interaction->transaction_data->qr_code_base64;
        $dataHora = new \DateTime($response->date_of_expiration);
        $dataHoraFormatada = $dataHora->format('d/m/Y H:i');
        
        return array(
            "success" => true,
            "message" => "Pedido realizado com sucesso!",
            "qr_code_64" => $qr_code_64,
            "data_expiracao" => $dataHoraFormatada
        );
    }

    public function gerarPagamentoPix($user, $plano)
    {   
        $plano->valor = floatval($plano->valor);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'      {
                "transaction_amount": '.$plano->valor.',
                "payment_method_id": "pix",
                "payer": {
                    "email": "'.$user->email.'",
                    "first_name": "'.$user->name.'",
                    "last_name": "",
                    "identification": {
                        "type": "CPF",
                        "number": "'.$user->cpf.'"
                    }
                },
                "description": "'.$plano->nome.'",
                "external_reference": "'.$plano->id.'",
                "notification_url": "https://gabrielaramires.com.br/mercado-pago"
              }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer APP_USR-6943513644521036-030709-a192b307d562388941969106bca3e8be-247133647',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;

    }
}
