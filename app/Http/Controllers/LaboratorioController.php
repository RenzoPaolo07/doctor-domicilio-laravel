<?php

namespace App\Http\Controllers;

use App\Models\OrdenLaboratorio;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaboratorioController extends Controller
{
    public function index()
    {
        $ordenes = OrdenLaboratorio::with('paciente')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('laboratorio.index', compact('ordenes'));
    }

    public function createOrden($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('laboratorio.create', compact('paciente'));
    }

    public function storeOrden(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha_orden' => 'required|date',
            'examenes_solicitados' => 'required|string',
            'indicaciones' => 'nullable|string',
        ]);

        OrdenLaboratorio::create([
            'paciente_id' => $request->paciente_id,
            'fecha_orden' => $request->fecha_orden,
            'examenes_solicitados' => $request->examenes_solicitados,
            'indicaciones' => $request->indicaciones,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('laboratorio.index')
            ->with('success', 'Orden de laboratorio creada exitosamente.');
    }

    public function showOrden($id)
    {
        $orden = OrdenLaboratorio::with('paciente')->findOrFail($id);
        return view('laboratorio.show', compact('orden'));
    }

    public function uploadResultados($id)
    {
        $orden = OrdenLaboratorio::findOrFail($id);
        return view('laboratorio.upload', compact('orden'));
    }

    public function storeResultados(Request $request, $id)
    {
        $orden = OrdenLaboratorio::findOrFail($id);

        $request->validate([
            'archivo_resultado' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($request->hasFile('archivo_resultado')) {
            // Eliminar archivo anterior si existe
            if ($orden->archivo_resultado) {
                Storage::disk('public')->delete($orden->archivo_resultado);
            }

            $path = $request->file('archivo_resultado')->store('laboratorio', 'public');
            
            $orden->update([
                'archivo_resultado' => $path,
                'estado' => 'realizado',
            ]);
        }

        return redirect()->route('laboratorio.show', $orden->id)
            ->with('success', 'Resultados subidos exitosamente.');
    }

    public function downloadResultados($id)
    {
        $orden = OrdenLaboratorio::findOrFail($id);
        
        if (!$orden->archivo_resultado) {
            return redirect()->back()->with('error', 'No hay archivo disponible.');
        }

        return Storage::disk('public')->download($orden->archivo_resultado);
    }

    public function destroy($id)
    {
        $orden = OrdenLaboratorio::findOrFail($id);
        
        if ($orden->archivo_resultado) {
            Storage::disk('public')->delete($orden->archivo_resultado);
        }
        
        $orden->delete();

        return response()->json(['success' => true]);
    }
}