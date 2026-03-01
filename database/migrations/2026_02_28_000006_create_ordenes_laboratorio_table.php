<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordenes_laboratorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->date('fecha_orden');
            $table->text('examenes_solicitados')->nullable();
            $table->text('indicaciones')->nullable();
            $table->enum('estado', ['pendiente', 'realizado'])->default('pendiente');
            $table->string('archivo_resultado')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordenes_laboratorio');
    }
};