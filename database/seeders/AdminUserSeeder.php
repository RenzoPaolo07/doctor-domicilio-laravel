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
        User::create([
            'nombre' => 'Dr. Alex',
            'email' => 'dr.alex@clinica.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);

        User::create([
            'nombre' => 'Dr. Asistente',
            'email' => 'asistente@clinica.com',
            'password' => Hash::make('admin123'),
            'rol' => 'asistente',
        ]);
    }
}