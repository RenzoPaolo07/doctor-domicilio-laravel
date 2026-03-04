<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Paciente::all()
        ]);
    }

    public function show($id)
    {
        $paciente = Paciente::find($id);
        
        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $paciente
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'nullable|email|unique:pacientes,email',
        ]);

        $paciente = Paciente::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Paciente creado',
            'data' => $paciente
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);
        
        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        $paciente->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Paciente actualizado',
            'data' => $paciente
        ]);
    }

    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        
        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        $paciente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paciente eliminado'
        ]);
    }

    public function buscar(Request $request)
    {
        $term = $request->get('q');
        
        $pacientes = Paciente::where('nombre', 'LIKE', "%{$term}%")
            ->orWhere('apellido', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pacientes
        ]);
    }
}