@extends('layouts.app')

@section('page-title', 'Órdenes de Laboratorio')
@section('title', 'Laboratorio')

@section('content')
<!-- Estadísticas rápidas -->
<div class="stats-grid" style="margin-bottom: 20px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <i class="fas fa-flask"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $ordenes->count() }}</h3>
            <p>Total Órdenes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $ordenes->where('estado', 'pendiente')->count() }}</h3>
            <p>Pendientes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $ordenes->where('estado', 'realizado')->count() }}</h3>
            <p>Realizados</p>
        </div>
    </div>
</div>

<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscar" placeholder="Buscar por paciente...">
    </div>
    
    <div class="toolbar-actions">
        <a href="{{ route('pacientes.index') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i> Nueva Orden
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-flask"></i> Órdenes de Laboratorio</h3>
    </div>
    <div class="card-body">
        @if($ordenes->count() > 0)
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
                        <td><strong>{{ $orden->paciente->nombre_completo }}</strong></td>
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
        @else
            <div class="empty-state">
                <i class="fas fa-flask"></i>
                <h3>No hay órdenes de laboratorio</h3>
                <p>Comienza creando una nueva orden</p>
                <a href="{{ route('pacientes.index') }}" class="btn-empty">
                    <i class="fas fa-plus"></i> Nueva Orden
                </a>
            </div>
        @endif
    </div>
</div>
@endsection