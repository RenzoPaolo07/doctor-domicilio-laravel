<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditoria';
    
    protected $fillable = [
        'usuario_id',
        'accion',
        'modelo',
        'modelo_id',
        'datos_antiguos',
        'datos_nuevos',
        'ip',
        'user_agent'
    ];

    protected $casts = [
        'datos_antiguos' => 'array',
        'datos_nuevos' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}