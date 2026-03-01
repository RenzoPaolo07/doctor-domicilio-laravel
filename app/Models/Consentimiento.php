<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consentimiento extends Model
{
    use HasFactory;

    protected $table = 'consentimientos';
    
    protected $fillable = [
        'paciente_id',
        'fecha',
        'procedimiento',
        'firma_digital',
        'testigos'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // RELACIONES
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}