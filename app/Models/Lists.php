<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;

    protected $table = 'lists'; // Nome da tabela no banco de dados

    protected $fillable = ['user_id', 'name', 'contacts']; // Campos que podem ser atribuídos em massa

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
