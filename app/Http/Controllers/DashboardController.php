<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\HistoriaClinica;
use App\Models\Receta;
use App\Models\Boleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $totalPacientes = Paciente::count();
        $hombres = Paciente::where('genero', 'M')->count();
        $mujeres = Paciente::where('genero', 'F')->count();
        $adultosMayores = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->count();
        
        // Últimos pacientes
        $ultimosPacientes = Paciente::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Próximas citas
        $proximasCitas = HistoriaClinica::with('paciente')
            ->whereNotNull('proxima_cita')
            ->where('proxima_cita', '>=', now())
            ->orderBy('proxima_cita')
            ->limit(5)
            ->get();
        
        // Actividad reciente (últimas recetas)
        $actividadReciente = Receta::with('paciente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Estadísticas financieras del mes
        $ingresosMes = Boleta::where('estado', 'pagado')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('monto');
        
        $boletasPendientes = Boleta::where('estado', 'pendiente')->count();
        
        // 📊 GRÁFICO 1: Pacientes por rango de edades
        $edades = Paciente::select(DB::raw('
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 18 THEN "0-17 años (Niños)"
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 30 THEN "18-30 años (Jóvenes)"
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 31 AND 50 THEN "31-50 años (Adultos)"
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 51 AND 65 THEN "51-65 años (Adultos Mayores)"
                ELSE "65+ años (Tercera Edad)"
            END as rango,
            COUNT(*) as total
        '))
        ->whereNotNull('fecha_nacimiento')
        ->groupBy('rango')
        ->get();
        
        // Si no hay datos, crear datos de ejemplo para mostrar el gráfico
        if ($edades->isEmpty()) {
            $edades = collect([
                (object) ['rango' => '0-17 años (Niños)', 'total' => 0],
                (object) ['rango' => '18-30 años (Jóvenes)', 'total' => 0],
                (object) ['rango' => '31-50 años (Adultos)', 'total' => 0],
                (object) ['rango' => '51-65 años (Adultos Mayores)', 'total' => 0],
                (object) ['rango' => '65+ años (Tercera Edad)', 'total' => 0],
            ]);
        }
        
        // 📊 GRÁFICO 2: Pacientes por tipo de sangre
        $sangre = Paciente::select('tipo_sangre', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_sangre')
            ->where('tipo_sangre', '!=', '')
            ->groupBy('tipo_sangre')
            ->get();
        
        // Si no hay datos, crear datos de ejemplo
        if ($sangre->isEmpty()) {
            $sangre = collect([
                (object) ['tipo_sangre' => 'A+', 'total' => 0],
                (object) ['tipo_sangre' => 'A-', 'total' => 0],
                (object) ['tipo_sangre' => 'B+', 'total' => 0],
                (object) ['tipo_sangre' => 'B-', 'total' => 0],
                (object) ['tipo_sangre' => 'O+', 'total' => 0],
                (object) ['tipo_sangre' => 'O-', 'total' => 0],
                (object) ['tipo_sangre' => 'AB+', 'total' => 0],
                (object) ['tipo_sangre' => 'AB-', 'total' => 0],
            ]);
        }
        
        return view('dashboard', compact(
            'totalPacientes',
            'hombres',
            'mujeres',
            'adultosMayores',
            'ultimosPacientes',
            'proximasCitas',
            'actividadReciente',
            'ingresosMes',
            'boletasPendientes',
            'edades',
            'sangre'
        ));
    }
}