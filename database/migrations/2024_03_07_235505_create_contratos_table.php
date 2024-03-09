<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('plano_id')->constrained('planos');
            $table->string('plano_name');
            $table->enum('status', ['ativo', 'desativado'])->default('ativo');
            $table->date('pagode')->nullable();
            $table->date('pagoate')->nullable();
            $table->boolean('removido')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
