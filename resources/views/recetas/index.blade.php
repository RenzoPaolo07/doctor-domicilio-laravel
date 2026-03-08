@extends('layouts.app')

@section('page-title', 'Recetas Médicas')
@section('title', 'Recetas')

@section('content')
<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscar" placeholder="Buscar por paciente...">
    </div>
    
    <div class="toolbar-actions">
        <a href="{{ route('pacientes.index') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i> Nueva Receta
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-prescription"></i> Listado de Recetas</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Diagnóstico</th>
                    <th>Médico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recetas as $receta)
                <tr>
                    <td>#{{ $receta->id }}</td>
                    <td><strong>{{ $receta->paciente->nombre_completo }}</strong></td>
                    <td>{{ $receta->fecha_emision->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($receta->diagnostico ?? 'N/E', 30) }}</td>
                    <td>Dr. {{ $receta->doctor->nombre ?? 'N/E' }}</td>
                    <td>
                        <a href="{{ route('recetas.show', $receta->id) }}" class="btn-small">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('recetas.pdf', $receta->id) }}" class="btn-small">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection