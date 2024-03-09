<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'nome', 'descricao', 'features', 'status', 'valor', 'limite_envios'];
}
