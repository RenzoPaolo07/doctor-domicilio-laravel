@extends('layouts.app')

@section('page-title', 'Registro de Auditoría')
@section('title', 'Auditoría')

@section('content')
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Registro de Actividades</h3>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <form method="GET" class="form-row" style="margin-bottom: 20px;">
            <div class="form-group" style="flex: 1;">
                <select name="modelo" class="form-control">
                    <option value="">Todos los módulos</option>
                    <option value="pacientes" {{ request('modelo') == 'pacientes' ? 'selected' : '' }}>Pacientes</option>
                    <option value="historias" {{ request('modelo') == 'historias' ? 'selected' : '' }}>Historias</option>
                    <option value="recetas" {{ request('modelo') == 'recetas' ? 'selected' : '' }}>Recetas</option>
                    <option value="boletas" {{ request('modelo') == 'boletas' ? 'selected' : '' }}>Boletas</option>
                </select>
            </div>
            
            <div class="form-group" style="flex: 1;">
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control" placeholder="Fecha inicio">
            </div>
            
            <div class="form-group" style="flex: 1;">
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control" placeholder="Fecha fin">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn-submit">Filtrar</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Módulo</th>
                    <th>Fecha</th>
                    <th>IP</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auditorias as $a)
                <tr>
                    <td>#{{ $a->id }}</td>
                    <td>{{ $a->usuario->nombre ?? 'Sistema' }}</td>
                    <td>
                        @if($a->accion == 'POST')
                            <span class="badge badge-success">CREAR</span>
                        @elseif($a->accion == 'PUT' || $a->accion == 'PATCH')
                            <span class="badge badge-warning">EDITAR</span>
                        @elseif($a->accion == 'DELETE')
                            <span class="badge badge-danger">ELIMINAR</span>
                        @else
                            <span class="badge badge-info">{{ $a->accion }}</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($a->modelo) }}</td>
                    <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $a->ip }}</td>
                    <td>
                        <a href="{{ route('auditoria.show', $a->id) }}" class="btn-small">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $auditorias->links() }}
    </div>
</div>
@endsection