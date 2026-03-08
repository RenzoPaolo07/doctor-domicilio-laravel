@extends('layouts.app')

@section('page-title', 'Detalle de Boleta')
@section('title', 'Boleta')

@section('content')
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-file-invoice"></i> Boleta {{ $boleta->numero_boleta }}</h3>
        <a href="{{ route('boletas.pdf', $boleta->id) }}" class="btn-add">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
    <div class="card-body">
        <div class="detalle-paciente">
            <div class="detalle-header">
                <div class="detalle-avatar" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    {{ substr($boleta->paciente->nombre, 0, 1) }}{{ substr($boleta->paciente->apellido, 0, 1) }}
                </div>
                <div class="detalle-titulo">
                    <h2>{{ $boleta->paciente->nombre_completo }}</h2>
                    <p><i class="fas fa-calendar-alt"></i> Fecha: {{ $boleta->fecha->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="detalle-grid">
                <div class="detalle-seccion">
                    <h3><i class="fas fa-info-circle"></i> Información de la Boleta</h3>
                    <p><strong>Número:</strong> {{ $boleta->numero_boleta }}</p>
                    <p><strong>Fecha:</strong> {{ $boleta->fecha->format('d/m/Y') }}</p>
                    <p><strong>Método de Pago:</strong> {{ ucfirst($boleta->metodo_pago ?? 'No especificado') }}</p>
                    <p><strong>Estado:</strong> 
                        @if($boleta->estado == 'pagado')
                            <span class="badge badge-success">Pagado</span>
                        @elseif($boleta->estado == 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @else
                            <span class="badge badge-danger">Anulado</span>
                        @endif
                    </p>
                </div>

                <div class="detalle-seccion">
                    <h3><i class="fas fa-dollar-sign"></i> Monto</h3>
                    <p style="font-size: 24px; font-weight: bold; color: #28a745;">
                        S/ {{ number_format($boleta->monto, 2) }}
                    </p>
                </div>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-file-alt"></i> Concepto</h3>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    {{ $boleta->concepto }}
                </div>
            </div>

            <div class="detalle-acciones" style="margin-top: 30px;">
                <a href="{{ route('boletas.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                @if($boleta->estado == 'pendiente')
                <button class="btn-submit" onclick="cambiarEstado({{ $boleta->id }}, 'pagado')">
                    <i class="fas fa-check"></i> Marcar como Pagado
                </button>
                @endif
            </div>
        </div>
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