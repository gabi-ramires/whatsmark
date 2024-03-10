<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('valor_total', 8, 2);
            $table->unsignedBigInteger('id_pix');
            $table->string('status_pix')->nullable();
            $table->date('data_expiracao_pix')->nullable(); 
            $table->text('requisicao_pix')->nullable();
            $table->text('resposta_pix')->nullable();
            $table->timestamps(); // Adiciona automaticamente os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
