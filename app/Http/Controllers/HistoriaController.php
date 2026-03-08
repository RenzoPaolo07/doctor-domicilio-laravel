<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use App\Models\HistoriaPediatrica;
use App\Models\Paciente;
use App\Models\Vacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaController extends Controller
{
    public function index($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        $historias = HistoriaClinica::where('paciente_id', $paciente_id)->get();
        $pediatricas = HistoriaPediatrica::where('paciente_id', $paciente_id)->get();
        
        return view('historias.index', compact('paciente', 'historias', 'pediatricas'));
    }

    public function createGeneral($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('historias.general.create', compact('paciente'));
    }

    public function storeGeneral(Request $request)
    {
        // Temporal
        return redirect()->route('historias.index', $request->paciente_id);
    }

    public function showGeneral($id)
    {
        \Log::info('Mostrando historia general ID: ' . $id);
        
        try {
            $historia = HistoriaClinica::with('paciente', 'doctor')->findOrFail($id);
            \Log::info('Historia encontrada: ' . $historia->id);
            
            return view('historias.general.show', compact('historia'));
        } catch (\Exception $e) {
            \Log::error('Error al mostrar historia: ' . $e->getMessage());
            return abort(404);
        }
    }

    public function createPediatrica($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('historias.pediatrica.create', compact('paciente'));
    }

    public function storePediatrica(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'motivo_consulta' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $historia = HistoriaPediatrica::create([
                'paciente_id' => $request->paciente_id,
                'fecha' => $request->fecha,
                'motivo_consulta' => $request->motivo_consulta,
                'enfermedad_actual' => $request->enfermedad_actual,
                'gestacion_semanas' => $request->gestacion_semanas,
                'parto_tipo' => $request->parto_tipo,
                'peso_nacer' => $request->peso_nacer,
                'talla_nacer' => $request->talla_nacer,
                'perimetro_cefalico_nacer' => $request->perimetro_cefalico_nacer,
                'apgar_1min' => $request->apgar_1min,
                'apgar_5min' => $request->apgar_5min,
                'lactancia_materna' => $request->lactancia_materna,
                'sostiene_cabeza_meses' => $request->sostiene_cabeza_meses,
                'se_sienta_meses' => $request->se_sienta_meses,
                'gatea_meses' => $request->gatea_meses,
                'camina_meses' => $request->camina_meses,
                'primeras_palabras_meses' => $request->primeras_palabras_meses,
                'control_esfinteres' => $request->control_esfinteres,
                'peso_actual' => $request->peso_actual,
                'talla_actual' => $request->talla_actual,
                'perimetro_cefalico_actual' => $request->perimetro_cefalico_actual,
                'percentil_peso' => $request->percentil_peso,
                'percentil_talla' => $request->percentil_talla,
                'percentil_pc' => $request->percentil_pc,
                'temperatura' => $request->temperatura,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
                'diagnostico' => $request->diagnostico,
                'tratamiento' => $request->tratamiento,
                'observaciones' => $request->observaciones,
                'proxima_cita' => $request->proxima_cita,
                'doctor_id' => auth()->id(),
            ]);

            // Guardar vacunas
            if ($request->has('vacunas')) {
                foreach ($request->vacunas as $vacuna) {
                    if (!empty($vacuna['vacuna'])) {
                        Vacuna::create([
                            'historia_pediatrica_id' => $historia->id,
                            'vacuna' => $vacuna['vacuna'],
                            'dosis' => $vacuna['dosis'] ?? null,
                            'fecha_aplicacion' => $vacuna['fecha_aplicacion'] ?? null,
                            'lote' => $vacuna['lote'] ?? null,
                            'establecimiento' => $vacuna['establecimiento'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('historias.pediatrica.show', $historia->id)
                ->with('success', 'Historia pediátrica guardada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar historia pediátrica: ' . $e->getMessage());
            return back()->with('error', 'Error al guardar: ' . $e->getMessage())->withInput();
        }
    }

    public function showPediatrica($id)
    {
        $historia = HistoriaPediatrica::with('paciente', 'doctor')->findOrFail($id);
        return view('historias.pediatrica.show', compact('historia'));
    }
}