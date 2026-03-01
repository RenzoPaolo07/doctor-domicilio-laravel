@extends('layouts.app')

@section('page-title', 'Órdenes de Laboratorio')
@section('title', 'Laboratorio')

@section('content')
<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscarOrden" placeholder="Buscar por paciente...">
    </div>
    
    <div class="toolbar-actions">
        <a href="{{ route('pacientes.index') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i>
            Nueva Orden
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-flask"></i> Órdenes de Laboratorio</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Exámenes</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenes as $orden)
                <tr>
                    <td>#{{ $orden->id }}</td>
                    <td>
                        <strong>{{ $orden->paciente->nombre_completo }}</strong>
                    </td>
                    <td>{{ $orden->fecha_orden->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($orden->examenes_solicitados, 30) }}</td>
                    <td>
                        @if($orden->estado == 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @else
                            <span class="badge badge-success">Realizado</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('laboratorio.show', $orden->id) }}" class="btn-small">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($orden->estado == 'pendiente')
                            <a href="{{ route('laboratorio.upload', $orden->id) }}" class="btn-small">
                                <i class="fas fa-upload"></i>
                            </a>
                        @endif
                        @if($orden->archivo_resultado)
                            <a href="{{ route('laboratorio.download', $orden->id) }}" class="btn-small">
                                <i class="fas fa-download"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection