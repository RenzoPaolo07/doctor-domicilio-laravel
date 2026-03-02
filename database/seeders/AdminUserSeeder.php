<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar usuario existente si hay
        User::where('email', 'dr.alex@clinica.com')->delete();
        
        // Crear usuario con contraseña hasheada
        User::create([
            'nombre' => 'Dr. Alex',
            'email' => 'dr.alex@clinica.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);
        
        $this->command->info('Usuario admin creado exitosamente!');
    }
}