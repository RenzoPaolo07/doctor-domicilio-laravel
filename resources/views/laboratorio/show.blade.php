@extends('layouts.app')

@section('page-title', 'Detalle de Orden de Laboratorio')
@section('title', 'Orden de Laboratorio')

@section('content')
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-flask"></i> Orden de Laboratorio #{{ $orden->id }}</h3>
        <a href="{{ route('laboratorio.index') }}" class="btn-add">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="card-body">
        <div class="detalle-paciente">
            <div class="detalle-header">
                <div class="detalle-avatar" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    {{ substr($orden->paciente->nombre, 0, 1) }}{{ substr($orden->paciente->apellido, 0, 1) }}
                </div>
                <div class="detalle-titulo">
                    <h2>{{ $orden->paciente->nombre_completo }}</h2>
                    <p><i class="fas fa-calendar-alt"></i> Fecha de orden: {{ $orden->fecha_orden->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-stethoscope"></i> Exámenes Solicitados</h3>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; white-space: pre-line;">
                    {{ $orden->examenes_solicitados }}
                </div>
            </div>

            @if($orden->indicaciones)
            <div class="detalle-seccion">
                <h3><i class="fas fa-file-alt"></i> Indicaciones</h3>
                <p>{{ $orden->indicaciones }}</p>
            </div>
            @endif

            <div class="detalle-seccion">
                <h3><i class="fas fa-info-circle"></i> Estado</h3>
                <p>
                    @if($orden->estado == 'pendiente')
                        <span class="badge badge-warning">Pendiente de resultados</span>
                    @else
                        <span class="badge badge-success">Resultados disponibles</span>
                    @endif
                </p>
            </div>

            @if($orden->archivo_resultado)
            <div class="detalle-seccion">
                <h3><i class="fas fa-file-pdf"></i> Resultados</h3>
                <a href="{{ route('laboratorio.download', $orden->id) }}" class="btn-submit">
                    <i class="fas fa-download"></i> Descargar Resultados PDF
                </a>
            </div>
            @endif

            @if($orden->estado == 'pendiente')
            <div class="detalle-acciones">
                <a href="{{ route('laboratorio.upload', $orden->id) }}" class="btn-submit">
                    <i class="fas fa-upload"></i> Subir Resultados
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection