<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtratoEnviosTable extends Migration
{
    public function up()
    {
        Schema::create('extrato_envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedInteger('limite');
            $table->unsignedInteger('creditos');
            $table->unsignedInteger('envios');
            $table->unsignedInteger('saldo');
            $table->text('motivo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('extrato_envios');
    }
}
