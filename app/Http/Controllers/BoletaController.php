<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    public function index()
    {
        $boletas = Boleta::with('paciente')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalIngresos = Boleta::where('estado', 'pagado')->sum('monto');
        $boletasPendientes = Boleta::where('estado', 'pendiente')->count();
        $boletasPagadas = Boleta::where('estado', 'pagado')->count();
        
        return view('boletas.index', compact('boletas', 'totalIngresos', 'boletasPendientes', 'boletasPagadas'));
    }

    public function create($paciente_id)
    {
        $paciente = Paciente::findOrFail($paciente_id);
        return view('boletas.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'concepto' => 'required|string',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,otro',
            'estado' => 'required|in:pendiente,pagado,anulado',
        ]);

        Boleta::create($request->all());

        return redirect()->route('boletas.index')
            ->with('success', 'Boleta creada exitosamente.');
    }

    public function show($id)
    {
        $boleta = Boleta::with('paciente')->findOrFail($id);
        return view('boletas.show', compact('boleta'));
    }

    public function pdf($id)
    {
        $boleta = Boleta::with('paciente')->findOrFail($id);
        
        $pdf = PDF::loadView('boletas.pdf', compact('boleta'));
        
        return $pdf->download('boleta-' . $boleta->numero_boleta . '.pdf');
    }

    public function updateEstado(Request $request, $id)
    {
        $boleta = Boleta::findOrFail($id);
        
        $request->validate([
            'estado' => 'required|in:pendiente,pagado,anulado',
        ]);

        $boleta->update(['estado' => $request->estado]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $boleta = Boleta::findOrFail($id);
        $boleta->delete();

        return response()->json(['success' => true]);
    }
}