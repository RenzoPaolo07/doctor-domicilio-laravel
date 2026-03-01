<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\HistoriaClinica;
use App\Models\HistoriaPediatrica;

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
        $historia = HistoriaClinica::with('paciente', 'doctor')->findOrFail($id);
        return view('historias.general.show', compact('historia'));
    }

    public function createPediatrica($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('historias.pediatrica.create', compact('paciente'));
    }

    public function storePediatrica(Request $request)
    {
        // Temporal
        return redirect()->route('historias.index', $request->paciente_id);
    }

    public function showPediatrica($id)
    {
        $historia = HistoriaPediatrica::with('paciente', 'doctor')->findOrFail($id);
        return view('historias.pediatrica.show', compact('historia'));
    }
}