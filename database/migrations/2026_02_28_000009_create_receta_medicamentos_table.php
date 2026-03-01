<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receta_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receta_id');
            $table->string('medicamento');
            $table->string('dosis')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('duracion')->nullable();
            $table->timestamps();
            
            $table->foreign('receta_id')
                  ->references('id')
                  ->on('recetas')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receta_medicamentos');
    }
};