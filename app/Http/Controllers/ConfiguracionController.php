<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::all()->groupBy('grupo');
        return view('configuraciones.index', compact('configuraciones'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $clave => $valor) {
            Configuracion::set($clave, $valor);
        }

        return redirect()->route('configuraciones.index')
            ->with('success', 'Configuraciones actualizadas exitosamente.');
    }

    public function reset()
    {
        // Valores por defecto
        $defaults = [
            ['clave' => 'sitio_nombre', 'valor' => 'Doctor Domicilio', 'grupo' => 'general'],
            ['clave' => 'sitio_descripcion', 'valor' => 'Sistema de Gestión Clínica', 'grupo' => 'general'],
            ['clave' => 'email_contacto', 'valor' => 'info@doctordomicilio.com', 'grupo' => 'contacto'],
            ['clave' => 'telefono_contacto', 'valor' => '+51 999 888 777', 'grupo' => 'contacto'],
            ['clave' => 'direccion', 'valor' => 'Av. Principal 123', 'grupo' => 'contacto'],
            ['clave' => 'moneda', 'valor' => 'S/', 'grupo' => 'facturacion'],
            ['clave' => 'impuesto', 'valor' => '18', 'tipo' => 'numero', 'grupo' => 'facturacion'],
        ];

        foreach ($defaults as $default) {
            Configuracion::updateOrCreate(
                ['clave' => $default['clave']],
                $default
            );
        }

        return redirect()->route('configuraciones.index')
            ->with('success', 'Configuraciones restauradas a valores por defecto.');
    }
}