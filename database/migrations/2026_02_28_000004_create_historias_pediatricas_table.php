<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historias_pediatricas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->date('fecha');
            $table->text('motivo_consulta')->nullable();
            $table->text('enfermedad_actual')->nullable();
            $table->integer('gestacion_semanas')->nullable();
            $table->enum('parto_tipo', ['vaginal', 'cesarea', 'forceps'])->nullable();
            $table->decimal('peso_nacer', 5, 2)->nullable();
            $table->decimal('talla_nacer', 5, 2)->nullable();
            $table->decimal('perimetro_cefalico_nacer', 5, 2)->nullable();
            $table->integer('apgar_1min')->nullable();
            $table->integer('apgar_5min')->nullable();
            $table->enum('lactancia_materna', ['exclusiva', 'mixta', 'artificial', 'destete'])->nullable();
            $table->text('vacunas')->nullable();
            $table->integer('sostiene_cabeza_meses')->nullable();
            $table->integer('se_sienta_meses')->nullable();
            $table->integer('gatea_meses')->nullable();
            $table->integer('camina_meses')->nullable();
            $table->integer('primeras_palabras_meses')->nullable();
            $table->text('control_esfinteres')->nullable();
            $table->decimal('peso_actual', 5, 2)->nullable();
            $table->decimal('talla_actual', 5, 2)->nullable();
            $table->decimal('perimetro_cefalico_actual', 5, 2)->nullable();
            $table->integer('percentil_peso')->nullable();
            $table->integer('percentil_talla')->nullable();
            $table->integer('percentil_pc')->nullable();
            $table->decimal('temperatura', 4, 2)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->date('proxima_cita')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('historias_pediatricas');
    }
};