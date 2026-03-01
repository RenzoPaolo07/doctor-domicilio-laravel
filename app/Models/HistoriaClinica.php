<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    use HasFactory;

    protected $table = 'historias_clinicas';
    
    protected $fillable = [
        'paciente_id', 
        'fecha', 
        'motivo_consulta', 
        'enfermedad_actual',
        'antecedentes_personales', 
        'antecedentes_familiares', 
        'habitos',
        'temperatura', 
        'presion_arterial', 
        'frecuencia_cardiaca',
        'frecuencia_respiratoria', 
        'saturacion_oxigeno', 
        'peso', 
        'talla', 
        'imc',
        'diagnostico', 
        'plan_tratamiento', 
        'observaciones', 
        'proxima_cita', 
        'doctor_id'
    ];

    protected $casts = [
        'fecha' => 'date',
        'proxima_cita' => 'date',
    ];

    // RELACIONES
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Usuario::class, 'doctor_id');
    }

    // MUTATORS (para calcular IMC automáticamente)
    public function setPesoAttribute($value)
    {
        $this->attributes['peso'] = $value;
        $this->calcularIMC();
    }

    public function setTallaAttribute($value)
    {
        $this->attributes['talla'] = $value;
        $this->calcularIMC();
    }

    private function calcularIMC()
    {
        if (isset($this->attributes['peso']) && isset($this->attributes['talla']) && $this->attributes['talla'] > 0) {
            $talla_metros = $this->attributes['talla'] / 100;
            $this->attributes['imc'] = round($this->attributes['peso'] / ($talla_metros * $talla_metros), 2);
        }
    }
}