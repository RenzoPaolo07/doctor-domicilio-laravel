<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'ordenes_laboratorio';
    
    protected $fillable = [
        'paciente_id',
        'fecha_orden',
        'examenes_solicitados',
        'indicaciones',
        'estado',
        'archivo_resultado'
    ];

    protected $casts = [
        'fecha_orden' => 'date',
    ];

    // RELACIONES
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}