@extends('layouts.app')

@section('page-title', 'Boletas y Facturación')
@section('title', 'Boletas')

@section('content')
<!-- Estadísticas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-info">
            <h3>S/ {{ number_format($totalIngresos ?? 0, 2) }}</h3>
            <p>Total Ingresos</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $boletasPendientes ?? 0 }}</h3>
            <p>Boletas Pendientes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $boletasPagadas ?? 0 }}</h3>
            <p>Boletas Pagadas</p>
        </div>
    </div>
</div>

<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscar" placeholder="Buscar por paciente o número de boleta...">
    </div>
    
    <div class="toolbar-actions">
        <a href="{{ route('pacientes.index') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i> Nueva Boleta
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-file-invoice"></i> Listado de Boletas</h3>
    </div>
    <div class="card-body">
        @if(isset($boletas) && $boletas->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Boleta</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($boletas as $boleta)
                    <tr>
                        <td><strong>{{ $boleta->numero_boleta }}</strong></td>
                        <td>{{ $boleta->paciente->nombre_completo }}</td>
                        <td>{{ $boleta->fecha->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($boleta->concepto, 30) }}</td>
                        <td><strong>S/ {{ number_format($boleta->monto, 2) }}</strong></td>
                        <td>
                            @if($boleta->estado == 'pagado')
                                <span class="badge badge-success">Pagado</span>
                            @elseif($boleta->estado == 'pendiente')
                                <span class="badge badge-warning">Pendiente</span>
                            @else
                                <span class="badge badge-danger">Anulado</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('boletas.show', $boleta->id) }}" class="btn-small">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('boletas.pdf', $boleta->id) }}" class="btn-small">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            @if($boleta->estado == 'pendiente')
                            <button class="btn-small" onclick="cambiarEstado({{ $boleta->id }}, 'pagado')">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-file-invoice"></i>
                <h3>No hay boletas</h3>
                <p>Comienza creando una nueva boleta</p>
                <a href="{{ route('pacientes.index') }}" class="btn-empty">
                    <i class="fas fa-plus"></i> Nueva Boleta
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function cambiarEstado(id, estado) {
    Swal.fire({
        title: '¿Confirmar pago?',
        text: "Esta acción marcará la boleta como pagada",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#43e97b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, pagada',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/boletas/${id}/estado`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ estado: estado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Actualizado!',
                        'El estado de la boleta ha sido actualizado.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
}
</script>
@endsection