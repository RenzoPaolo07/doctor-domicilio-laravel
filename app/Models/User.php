<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
    ];

    /**
     * Los atributos que deben estar ocultos para las serializaciones.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // RELACIONES
    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class, 'doctor_id');
    }

    public function historiasPediatricas()
    {
        return $this->hasMany(HistoriaPediatrica::class, 'doctor_id');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'usuario_id');
    }

    // VERIFICACIONES DE ROL
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isDoctor()
    {
        return $this->rol === 'doctor';
    }

    public function isAsistente()
    {
        return $this->rol === 'asistente';
    }

    // ACCESORS
    public function getNombreCompletoAttribute()
    {
        return $this->nombre;
    }
}