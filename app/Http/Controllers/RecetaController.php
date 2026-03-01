<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Paciente;
use App\Models\RecetaMedicamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with('paciente', 'doctor')->orderBy('created_at', 'desc')->get();
        return view('recetas.index', compact('recetas'));
    }

    public function create($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('recetas.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha_emision' => 'required|date',
            'diagnostico' => 'nullable|string',
            'indicaciones' => 'nullable|string',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamento' => 'required|string',
            'medicamentos.*.dosis' => 'nullable|string',
            'medicamentos.*.frecuencia' => 'nullable|string',
            'medicamentos.*.duracion' => 'nullable|string',
        ]);

        // Crear la receta
        $receta = Receta::create([
            'paciente_id' => $request->paciente_id,
            'usuario_id' => auth()->id(),
            'fecha_emision' => $request->fecha_emision,
            'diagnostico' => $request->diagnostico,
            'indicaciones' => $request->indicaciones,
        ]);

        // Guardar los medicamentos
        foreach ($request->medicamentos as $med) {
            RecetaMedicamento::create([
                'receta_id' => $receta->id,
                'medicamento' => $med['medicamento'],
                'dosis' => $med['dosis'],
                'frecuencia' => $med['frecuencia'],
                'duracion' => $med['duracion'],
            ]);
        }

        return redirect()->route('recetas.show', $receta->id)
            ->with('success', 'Receta creada exitosamente.');
    }

    public function show($id)
    {
        $receta = Receta::with('paciente', 'doctor', 'medicamentos')->findOrFail($id);
        return view('recetas.show', compact('receta'));
    }

    public function pdf($id)
    {
        $receta = Receta::with('paciente', 'doctor', 'medicamentos')->findOrFail($id);
        
        $pdf = PDF::loadView('recetas.pdf', compact('receta'));
        
        return $pdf->download('receta-' . $receta->id . '.pdf');
    }

    public function destroy($id)
    {
        $receta = Receta::findOrFail($id);
        $receta->delete();
        
        return response()->json(['success' => true]);
    }
}