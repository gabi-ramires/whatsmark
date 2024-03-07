<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronTable extends Migration
{
    public function up()
    {
        Schema::create('cron', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->string('command');
            $table->string('schedule');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cron');
    }
}
