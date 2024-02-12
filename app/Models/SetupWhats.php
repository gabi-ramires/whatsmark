<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class SetupWhats extends Authenticatable
{
    use HasFactory;

    protected $table = 'setupWhats';

    protected $fillable = [
        'IdUser',
        'IdSession'
    ];

    // Relação com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'IdUser');
    }
}
