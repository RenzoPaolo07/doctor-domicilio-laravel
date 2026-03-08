@extends('layouts.app')

@section('page-title', 'Consentimientos Informados')
@section('title', 'Consentimientos')

@section('content')
<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscar" placeholder="Buscar por paciente...">
    </div>
    
    <div class="toolbar-actions">
        <a href="{{ route('pacientes.index') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i> Nuevo Consentimiento
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-file-signature"></i> Consentimientos Informados</h3>
    </div>
    <div class="card-body">
        @if(isset($consentimientos) && $consentimientos->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Procedimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consentimientos as $c)
                    <tr>
                        <td>#{{ $c->id }}</td>
                        <td><strong>{{ $c->paciente->nombre_completo }}</strong></td>
                        <td>{{ $c->fecha->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($c->procedimiento, 50) }}</td>
                        <td>
                            <a href="{{ route('consentimientos.show', $c->id) }}" class="btn-small">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('consentimientos.pdf', $c->id) }}" class="btn-small">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-file-signature"></i>
                <h3>No hay consentimientos informados</h3>
                <p>Comienza creando un nuevo consentimiento</p>
                <a href="{{ route('pacientes.index') }}" class="btn-empty">
                    <i class="fas fa-plus"></i> Nuevo Consentimiento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection