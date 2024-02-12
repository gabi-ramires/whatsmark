<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('setupWhats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser');
            $table->string('IdSession');
            $table->timestamps();

            // Chave estrangeira para a tabela users
            $table->foreign('IdUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup_whats');
    }
};
