<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtratoEnvios extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'limite',
        'creditos',
        'envios',
        'saldo',
        'motivo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
