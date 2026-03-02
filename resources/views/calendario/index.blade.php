@extends('layouts.app')

@section('page-title', 'Calendario de Citas')
@section('title', 'Calendario')

@push('styles')
<style>
    #calendar {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .fc-event {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .fc-event:hover {
        transform: scale(1.02);
    }
    .fc-toolbar-title {
        color: var(--dark);
    }
    .fc-button-primary {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .fc-button-primary:hover {
        background: var(--primary-dark) !important;
    }
</style>
@endpush

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr 300px;">
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-calendar-alt"></i> Calendario de Citas Médicas</h3>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle"></i> Nueva Cita</h3>
        </div>
        <div class="card-body">
            <form id="formCita">
                @csrf
                <div class="form-group">
                    <label>Paciente</label>
                    <select name="paciente_id" id="paciente_id" class="form-control" required>
                        <option value="">Seleccionar paciente</option>
                        @foreach(App\Models\Paciente::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea name="motivo" id="motivo" class="form-control" rows="2" required></textarea>
                </div>
                
                <button type="submit" class="btn-submit" style="width: 100%;">
                    <i class="fas fa-save"></i> Programar Cita
                </button>
            </form>
        </div>
        
        <hr>
        
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Próximas Citas</h3>
        </div>
        <div class="card-body" id="proximas-citas">
            @php
                $proximas = App\Models\HistoriaClinica::with('paciente')
                    ->whereNotNull('proxima_cita')
                    ->where('proxima_cita', '>=', now())
                    ->orderBy('proxima_cita')
                    ->limit(5)
                    ->get();
            @endphp
            
            @forelse($proximas as $cita)
            <div style="padding: 10px; margin-bottom: 10px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #4a69bd;">
                <strong>{{ $cita->paciente->nombre_completo }}</strong>
                <p style="font-size: 0.9rem; margin: 5px 0;">
                    <i class="fas fa-calendar"></i> {{ $cita->proxima_cita->format('d/m/Y') }}
                </p>
                <small>{{ Str::limit($cita->motivo_consulta, 30) }}</small>
            </div>
            @empty
            <p class="text-muted">No hay citas programadas</p>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'es',
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        events: '/calendario/eventos',
        eventClick: function(info) {
            Swal.fire({
                title: info.event.title,
                html: `
                    <p><strong>Motivo:</strong> ${info.event.extendedProps.motivo || 'No especificado'}</p>
                    <p><strong>Teléfono:</strong> ${info.event.extendedProps.telefono || 'N/E'}</p>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4a69bd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Editar fecha',
                cancelButtonText: 'Cancelar cita',
                showDenyButton: true,
                denyButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Editar fecha
                    Swal.fire({
                        title: 'Nueva fecha',
                        input: 'date',
                        inputValue: info.event.startStr,
                        showCancelButton: true,
                        confirmButtonText: 'Actualizar',
                        cancelButtonText: 'Cancelar'
                    }).then((dateResult) => {
                        if (dateResult.value) {
                            fetch(`/calendario/eventos/${info.event.id}`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ fecha: dateResult.value })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    calendar.refetchEvents();
                                    Swal.fire('Actualizado', 'La cita ha sido reprogramada', 'success');
                                }
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Cancelar cita
                    Swal.fire({
                        title: '¿Cancelar cita?',
                        text: 'Esta acción no se puede revertir',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e55039',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, cancelar'
                    }).then((cancelResult) => {
                        if (cancelResult.isConfirmed) {
                            fetch(`/calendario/eventos/${info.event.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    calendar.refetchEvents();
                                    Swal.fire('Cancelada', 'La cita ha sido cancelada', 'success');
                                }
                            });
                        }
                    });
                }
            });
        },
        dateClick: function(info) {
            document.getElementById('fecha').value = info.dateStr;
        }
    });
    
    calendar.render();
    
    // Formulario de nueva cita
    document.getElementById('formCita').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("calendario.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('¡Éxito!', 'Cita programada correctamente', 'success');
                calendar.refetchEvents();
                this.reset();
            }
        });
    });
});
</script>
@endsection