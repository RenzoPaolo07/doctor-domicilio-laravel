<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    public function index()
    {
        return view('laboratorio.index');
    }

    public function createOrden($paciente_id)
    {
        return view('laboratorio.create', compact('paciente_id'));
    }

    public function storeOrden(Request $request)
    {
        return redirect()->route('laboratorio.index');
    }
}