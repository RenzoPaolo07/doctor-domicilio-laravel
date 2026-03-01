<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::orderBy('created_at', 'desc')->get();
        $totalPacientes = $pacientes->count();
        $hombres = Paciente::where('genero', 'M')->count();
        $mujeres = Paciente::where('genero', 'F')->count();
        $adultosMayores = Paciente::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60')->count();
        
        return view('pacientes.index', compact('pacientes', 'totalPacientes', 'hombres', 'mujeres', 'adultosMayores'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'nullable|email|unique:pacientes,email',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pacientes', 'public');
            $data['foto'] = $path;
        }

        Paciente::create($data);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente creado exitosamente.');
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'nullable|email|unique:pacientes,email,' . $paciente->id,
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior
            if ($paciente->foto) {
                Storage::disk('public')->delete($paciente->foto);
            }
            $path = $request->file('foto')->store('pacientes', 'public');
            $data['foto'] = $path;
        }

        $paciente->update($data);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        
        if ($paciente->foto) {
            Storage::disk('public')->delete($paciente->foto);
        }
        
        $paciente->delete();

        return response()->json(['success' => true]);
    }

    public function buscar(Request $request)
    {
        $term = $request->get('q');
        $pacientes = Paciente::where('nombre', 'LIKE', "%{$term}%")
            ->orWhere('apellido', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('telefono', 'LIKE', "%{$term}%")
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($pacientes);
    }
}