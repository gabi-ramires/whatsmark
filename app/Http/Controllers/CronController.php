<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CronController
{
    public function cron($comando)
    {  
        $comando = str_replace("\n",'"\\\\\\\n"',$comando);

        // Executar o comando
        exec($comando, $output, $status);

        //var_dump($status); // 0 - ok  e  1 - erro

        // Verificar se o comando foi executado com sucesso
        if ($output === null) {
            return array('status' => true, 'message' => "Comando cron executado com sucesso");
        } else {
            return array('status' => false, 'message' => "Falha ao executar o comando cron");
        }
    }    
}

