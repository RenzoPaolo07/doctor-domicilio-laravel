<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vacunas_aplicadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_pediatrica_id')->constrained('historias_pediatricas')->onDelete('cascade');
            $table->string('vacuna');
            $table->string('dosis')->nullable();
            $table->date('fecha_aplicacion')->nullable();
            $table->string('lote')->nullable();
            $table->string('establecimiento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacunas_aplicadas');
    }
};