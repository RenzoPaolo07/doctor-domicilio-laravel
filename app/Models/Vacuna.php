<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $table = 'vacunas_aplicadas';
    
    protected $fillable = [
        'historia_pediatrica_id',
        'vacuna',
        'dosis',
        'fecha_aplicacion',
        'lote',
        'establecimiento'
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
    ];

    public function historiaPediatrica()
    {
        return $this->belongsTo(HistoriaPediatrica::class);
    }
}