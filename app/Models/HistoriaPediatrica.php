<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaPediatrica extends Model
{
    use HasFactory;

    protected $table = 'historias_pediatricas';
    
    protected $fillable = [
        'paciente_id', 
        'fecha', 
        'motivo_consulta', 
        'enfermedad_actual',
        'gestacion_semanas', 
        'parto_tipo', 
        'peso_nacer', 
        'talla_nacer',
        'perimetro_cefalico_nacer', 
        'apgar_1min', 
        'apgar_5min', 
        'lactancia_materna',
        'vacunas', 
        'sostiene_cabeza_meses', 
        'se_sienta_meses', 
        'gatea_meses',
        'camina_meses', 
        'primeras_palabras_meses', 
        'control_esfinteres',
        'peso_actual', 
        'talla_actual', 
        'perimetro_cefalico_actual',
        'percentil_peso', 
        'percentil_talla', 
        'percentil_pc',
        'temperatura', 
        'frecuencia_cardiaca', 
        'frecuencia_respiratoria',
        'diagnostico', 
        'tratamiento', 
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

    public function vacunasAplicadas()
    {
        return $this->hasMany(Vacuna::class, 'historia_pediatrica_id');
    }

    // Calcular edad en meses al momento de la consulta
    public function getEdadMesesAttribute()
    {
        if ($this->paciente && $this->paciente->fecha_nacimiento) {
            return $this->paciente->fecha_nacimiento->diffInMonths($this->fecha);
        }
        return null;
    }
}