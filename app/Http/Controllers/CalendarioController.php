<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }
    
    public function eventos()
    {
        // Aquí irá la lógica para obtener eventos del calendario
        $eventos = [
            [
                'title' => 'Cita con Paciente',
                'start' => now()->format('Y-m-d'),
                'backgroundColor' => '#4a69bd',
            ]
        ];
        
        return response()->json($eventos);
    }
}