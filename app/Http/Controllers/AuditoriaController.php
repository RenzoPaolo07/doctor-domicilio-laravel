<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Auditoria::with('usuario')->orderBy('created_at', 'desc');

        if ($request->has('modelo')) {
            $query->where('modelo', $request->modelo);
        }

        if ($request->has('usuario')) {
            $query->where('usuario_id', $request->usuario);
        }

        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $auditorias = $query->paginate(20);
        
        return view('auditoria.index', compact('auditorias'));
    }

    public function show($id)
    {
        $auditoria = Auditoria::with('usuario')->findOrFail($id);
        return view('auditoria.show', compact('auditoria'));
    }
}