<?php

namespace App\Http\Controllers;

use App\Models\Consentimiento;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsentimientoController extends Controller
{
    public function index()
    {
        $consentimientos = Consentimiento::with('paciente')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('consentimientos.index', compact('consentimientos'));
    }

    public function create($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('consentimientos.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'procedimiento' => 'required|string',
            'firma_digital' => 'required|string',
            'testigos' => 'nullable|string',
        ]);

        Consentimiento::create([
            'paciente_id' => $request->paciente_id,
            'fecha' => $request->fecha,
            'procedimiento' => $request->procedimiento,
            'firma_digital' => $request->firma_digital,
            'testigos' => $request->testigos,
        ]);

        return redirect()->route('consentimientos.index')
            ->with('success', 'Consentimiento guardado exitosamente.');
    }

    public function show($id)
    {
        $consentimiento = Consentimiento::with('paciente')->findOrFail($id);
        return view('consentimientos.show', compact('consentimiento'));
    }

    public function pdf($id)
    {
        $consentimiento = Consentimiento::with('paciente')->findOrFail($id);
        
        $pdf = PDF::loadView('consentimientos.pdf', compact('consentimiento'));
        
        return $pdf->download('consentimiento-' . $consentimiento->id . '.pdf');
    }
}