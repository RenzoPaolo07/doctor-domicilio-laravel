<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuraciones';
    
    protected $fillable = ['clave', 'valor', 'tipo', 'grupo'];

    protected $casts = [
        'valor' => 'array',
    ];

    public static function get($clave, $default = null)
    {
        $config = self::where('clave', $clave)->first();
        return $config ? $config->valor : $default;
    }

    public static function set($clave, $valor, $tipo = 'texto', $grupo = 'general')
    {
        return self::updateOrCreate(
            ['clave' => $clave],
            ['valor' => $valor, 'tipo' => $tipo, 'grupo' => $grupo]
        );
    }
}