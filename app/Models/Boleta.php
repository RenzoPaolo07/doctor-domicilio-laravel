<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $table = 'boletas';
    
    protected $fillable = [
        'paciente_id',
        'fecha',
        'monto',
        'concepto',
        'numero_boleta',
        'metodo_pago',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Generar número de boleta automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($boleta) {
            if (empty($boleta->numero_boleta)) {
                $boleta->numero_boleta = 'B' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}