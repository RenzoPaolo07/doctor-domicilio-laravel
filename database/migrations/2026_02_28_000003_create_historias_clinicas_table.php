<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->date('fecha');
            $table->text('motivo_consulta')->nullable();
            $table->text('enfermedad_actual')->nullable();
            $table->text('antecedentes_personales')->nullable();
            $table->text('antecedentes_familiares')->nullable();
            $table->text('habitos')->nullable();
            $table->decimal('temperatura', 4, 2)->nullable();
            $table->string('presion_arterial', 10)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->integer('saturacion_oxigeno')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 5, 2)->nullable();
            $table->decimal('imc', 4, 2)->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('plan_tratamiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->date('proxima_cita')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->timestamps();
            
            // Foreign keys después de crear la tabla
            $table->foreign('paciente_id')
                  ->references('id')
                  ->on('pacientes')
                  ->onDelete('cascade');
                  
            $table->foreign('doctor_id')
                  ->references('id')
                  ->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historias_clinicas');
    }
};