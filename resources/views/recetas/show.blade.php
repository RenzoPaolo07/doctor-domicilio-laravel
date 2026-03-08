@extends('layouts.app')

@section('page-title', 'Detalle de Receta')
@section('title', 'Receta Médica')

@section('content')
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-prescription"></i> Receta Médica #{{ $receta->id }}</h3>
        <a href="{{ route('recetas.pdf', $receta->id) }}" class="btn-add">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
    <div class="card-body">
        <div class="detalle-paciente">
            <div class="detalle-header">
                <div class="detalle-avatar" style="background: linear-gradient(135deg, #4a69bd, #6a89cc);">
                    {{ substr($receta->paciente->nombre, 0, 1) }}{{ substr($receta->paciente->apellido, 0, 1) }}
                </div>
                <div class="detalle-titulo">
                    <h2>{{ $receta->paciente->nombre_completo }}</h2>
                    <p><i class="fas fa-calendar-alt"></i> Fecha: {{ $receta->fecha_emision->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-user-md"></i> Médico</h3>
                <p>Dr. {{ $receta->doctor->nombre ?? 'No asignado' }}</p>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-stethoscope"></i> Diagnóstico</h3>
                <p>{{ $receta->diagnostico ?? 'No especificado' }}</p>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-pills"></i> Medicamentos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Dosis</th>
                            <th>Frecuencia</th>
                            <th>Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receta->medicamentos as $med)
                        <tr>
                            <td><strong>{{ $med->medicamento }}</strong></td>
                            <td>{{ $med->dosis ?? 'N/E' }}</td>
                            <td>{{ $med->frecuencia ?? 'N/E' }}</td>
                            <td>{{ $med->duracion ?? 'N/E' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($receta->indicaciones)
            <div class="detalle-seccion">
                <h3><i class="fas fa-file-alt"></i> Indicaciones</h3>
                <p>{{ $receta->indicaciones }}</p>
            </div>
            @endif

            <div class="detalle-acciones">
                <a href="{{ route('historias.index', $receta->paciente->id) }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection