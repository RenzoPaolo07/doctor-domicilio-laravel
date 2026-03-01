<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('usuario_id');
            $table->date('fecha_emision');
            $table->text('diagnostico')->nullable();
            $table->text('indicaciones')->nullable();
            $table->timestamps();
            
            $table->foreign('paciente_id')
                  ->references('id')
                  ->on('pacientes')
                  ->onDelete('cascade');
                  
            $table->foreign('usuario_id')
                  ->references('id')
                  ->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recetas');
    }
};