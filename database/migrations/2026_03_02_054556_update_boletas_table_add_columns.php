<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('boletas', function (Blueprint $table) {
            // Agregar columnas si no existen
            if (!Schema::hasColumn('boletas', 'metodo_pago')) {
                $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia', 'otro'])
                    ->nullable()
                    ->after('concepto');
            }
            
            if (!Schema::hasColumn('boletas', 'estado')) {
                $table->enum('estado', ['pendiente', 'pagado', 'anulado'])
                    ->default('pendiente')
                    ->after('metodo_pago');
            }
        });
    }

    public function down()
    {
        Schema::table('boletas', function (Blueprint $table) {
            $table->dropColumn(['metodo_pago', 'estado']);
        });
    }
};