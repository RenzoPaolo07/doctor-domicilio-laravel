<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relaciones
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

    // Verificar si es admin
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    // Verificar si es doctor
    public function isDoctor()
    {
        return $this->rol === 'doctor';
    }
}