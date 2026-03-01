<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsentimientoController extends Controller
{
    public function index()
    {
        return view('consentimientos.index');
    }

    public function create($paciente_id)
    {
        return view('consentimientos.create', compact('paciente_id'));
    }

    public function store(Request $request)
    {
        return redirect()->route('consentimientos.index');
    }
}