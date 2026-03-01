<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $table = 'recetas';
    
    protected $fillable = [
        'paciente_id',
        'usuario_id',
        'fecha_emision',
        'diagnostico',
        'indicaciones'
    ];

    protected $casts = [
        'fecha_emision' => 'date',
    ];

    // RELACIONES
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function medicamentos()
    {
        return $this->hasMany(RecetaMedicamento::class);
    }
}