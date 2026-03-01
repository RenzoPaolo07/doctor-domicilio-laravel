<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoletaController extends Controller
{
    public function index()
    {
        return view('boletas.index');
    }

    public function create($paciente_id)
    {
        return view('boletas.create', compact('paciente_id'));
    }

    public function store(Request $request)
    {
        return redirect()->route('boletas.index');
    }
}