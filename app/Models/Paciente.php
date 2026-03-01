<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    
    protected $fillable = [
        'nombre', 
        'apellido', 
        'fecha_nacimiento', 
        'genero', 
        'telefono', 
        'email', 
        'direccion', 
        'alergias', 
        'tipo_sangre', 
        'contacto_emergencia', 
        'telefono_emergencia', 
        'foto'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // RELACIONES
    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class);
    }

    public function historiasPediatricas()
    {
        return $this->hasMany(HistoriaPediatrica::class);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function ordenesLaboratorio()
    {
        return $this->hasMany(OrdenLaboratorio::class);
    }

    public function consentimientos()
    {
        return $this->hasMany(Consentimiento::class);
    }

    public function boletas()
    {
        return $this->hasMany(Boleta::class);
    }

    // ATRIBUTOS CALCULADOS
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    // SCOPES (consultas personalizadas)
    public function scopeHombres($query)
    {
        return $query->where('genero', 'M');
    }

    public function scopeMujeres($query)
    {
        return $query->where('genero', 'F');
    }

    public function scopeAdultosMayores($query)
    {
        return $query->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60');
    }

    public function scopeTipoSangre($query, $tipo)
    {
        return $query->where('tipo_sangre', $tipo);
    }

    // MÉTODOS ESTÁTICOS
    public static function getLast($limit = 5)
    {
        return self::orderBy('created_at', 'desc')->limit($limit)->get();
    }

    public static function countByGenero($genero)
    {
        return self::where('genero', $genero)->count();
    }

    public static function countAdultosMayores()
    {
        return self::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->count();
    }

    public static function search($term)
    {
        return self::where('nombre', 'LIKE', "%{$term}%")
            ->orWhere('apellido', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('telefono', 'LIKE', "%{$term}%")
            ->orderBy('created_at', 'desc')
            ->get();
    }
}