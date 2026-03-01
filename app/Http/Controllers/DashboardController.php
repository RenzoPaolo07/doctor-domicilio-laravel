<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\HistoriaClinica;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas para el dashboard
        $totalPacientes = Paciente::count();
        $hombres = Paciente::where('genero', 'M')->count();
        $mujeres = Paciente::where('genero', 'F')->count();
        $adultosMayores = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->count();
        
        // Últimos pacientes registrados
        $ultimosPacientes = Paciente::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Próximas citas (historias con próxima_cita en el futuro)
        $proximasCitas = HistoriaClinica::with('paciente')
            ->where('proxima_cita', '>=', now())
            ->orderBy('proxima_cita', 'asc')
            ->limit(5)
            ->get();
        
        // Actividad reciente (últimas recetas)
        $actividadReciente = Receta::with('paciente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'totalPacientes',
            'hombres',
            'mujeres',
            'adultosMayores',
            'ultimosPacientes',
            'proximasCitas',
            'actividadReciente'
        ));
    }
}