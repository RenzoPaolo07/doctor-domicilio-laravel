<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }

    public function eventos(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $citas = HistoriaClinica::with('paciente')
            ->whereNotNull('proxima_cita')
            ->whereBetween('proxima_cita', [$start, $end])
            ->get();

        $eventos = [];

        foreach ($citas as $cita) {
            $eventos[] = [
                'id' => $cita->id,
                'title' => 'Cita: ' . $cita->paciente->nombre_completo,
                'start' => $cita->proxima_cita->format('Y-m-d'),
                'backgroundColor' => '#4a69bd',
                'borderColor' => '#4a69bd',
                'textColor' => '#fff',
                'extendedProps' => [
                    'paciente' => $cita->paciente->nombre_completo,
                    'motivo' => $cita->motivo_consulta,
                    'telefono' => $cita->paciente->telefono
                ]
            ];
        }

        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'motivo' => 'required|string',
        ]);

        // Buscar o crear una historia clínica para esta cita
        $historia = HistoriaClinica::updateOrCreate(
            [
                'paciente_id' => $request->paciente_id,
                'fecha' => now()->toDateString()
            ],
            [
                'proxima_cita' => $request->fecha,
                'motivo_consulta' => $request->motivo,
                'doctor_id' => auth()->id()
            ]
        );

        return response()->json(['success' => true, 'id' => $historia->id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $historia = HistoriaClinica::findOrFail($id);
        $historia->update(['proxima_cita' => $request->fecha]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        $historia->update(['proxima_cita' => null]);

        return response()->json(['success' => true]);
    }
}