<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $table = 'envios';

    protected $fillable = [
        'user_id',
        'mensagem_enviada',
        'lista_enviada',
        'tipo_envio',
        'horario_envio',
    ];
}
