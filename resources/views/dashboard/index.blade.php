@extends('layouts.app')

@section('page-title', 'Panel de Control')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalPacientes }}</h3>
            <p>Pacientes Activos</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $proximasCitas->count() }}</h3>
            <p>Citas Programadas</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <i class="fas fa-flask"></i>
        </div>
        <div class="stat-info">
            <h3>12</h3>
            <p>Exámenes Pendientes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div class="stat-info">
            <h3>5</h3>
            <p>Boletas del Día</p>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-clock"></i> Próximas Citas</h3>
            <a href="{{ route('calendario.index') }}" class="btn-add">Ver Calendario</a>
        </div>
        <div class="card-body">
            <ul class="activity-list">
                @forelse($proximasCitas as $cita)
                <li>
                    <i class="fas fa-calendar-check activity-icon" style="background: #4facfe;"></i>
                    <div>
                        <p><strong>{{ $cita->paciente->nombre_completo }}</strong> - {{ $cita->motivo_consulta ?? 'Consulta' }}</p>
                        <small>{{ \Carbon\Carbon::parse($cita->proxima_cita)->format('d/m/Y') }}</small>
                    </div>
                </li>
                @empty
                <li>
                    <p>No hay citas programadas</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-history"></i> Actividad Reciente</h3>
        </div>
        <div class="card-body">
            <ul class="activity-list">
                @forelse($actividadReciente as $actividad)
                <li>
                    <i class="fas fa-prescription activity-icon" style="background: #f093fb;"></i>
                    <div>
                        <p><strong>Receta</strong> para {{ $actividad->paciente->nombre_completo }}</p>
                        <small>{{ $actividad->created_at->diffForHumans() }}</small>
                    </div>
                </li>
                @empty
                <li>
                    <p>No hay actividad reciente</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<div class="dashboard-card" style="margin-top: 20px;">
    <div class="card-header">
        <h3><i class="fas fa-user-plus"></i> Últimos Pacientes Registrados</h3>
        <a href="{{ route('pacientes.create') }}" class="btn-add">+ Nuevo</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimosPacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nombre_completo }}</td>
                    <td>{{ $paciente->email }}</td>
                    <td>{{ $paciente->telefono }}</td>
                    <td>
                        <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn-small">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" onclick="verDetalle({{ $paciente->id }})" class="btn-small">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Detalle del Paciente -->
<div id="pacienteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-user-circle"></i> Detalle del Paciente</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body" id="modal-body-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Cargando...
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function verDetalle(id) {
    const modal = document.getElementById('pacienteModal');
    const modalBody = document.getElementById('modal-body-content');
    
    modalBody.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
    modal.style.display = 'block';
    
    fetch(`/pacientes/${id}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = `
                <div class="detalle-paciente">
                    <div class="detalle-header">
                        <div class="detalle-avatar" style="background: linear-gradient(135deg, #4a69bd, #6a89cc);">
                            <span>${data.nombre.charAt(0)}${data.apellido.charAt(0)}</span>
                        </div>
                        <div class="detalle-titulo">
                            <h2>${data.nombre} ${data.apellido}</h2>
                            <p><i class="fas fa-calendar-alt"></i> ${data.edad} años (${data.fecha_nacimiento})</p>
                        </div>
                    </div>
                    
                    <div class="detalle-grid">
                        <div class="detalle-seccion">
                            <h3><i class="fas fa-address-card"></i> Información Personal</h3>
                            <p><strong>Email:</strong> ${data.email || 'No especificado'}</p>
                            <p><strong>Teléfono:</strong> ${data.telefono || 'No especificado'}</p>
                            <p><strong>Dirección:</strong> ${data.direccion || 'No especificada'}</p>
                            <p><strong>Género:</strong> ${data.genero === 'M' ? 'Masculino' : 'Femenino'}</p>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h3><i class="fas fa-heartbeat"></i> Información Médica</h3>
                            <p><strong>Tipo de Sangre:</strong> ${data.tipo_sangre || 'No especificado'}</p>
                            <p><strong>Alergias:</strong> ${data.alergias || 'Ninguna'}</p>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h3><i class="fas fa-phone-alt"></i> Contacto de Emergencia</h3>
                            <p><strong>Nombre:</strong> ${data.contacto_emergencia || 'No especificado'}</p>
                            <p><strong>Teléfono:</strong> ${data.telefono_emergencia || 'No especificado'}</p>
                        </div>
                    </div>
                    
                    <div class="detalle-acciones">
                        <a href="/recetas/crear/${data.id}" class="btn-accion-modal">
                            <i class="fas fa-prescription"></i> Nueva Receta
                        </a>
                        <a href="/historias/general/crear/${data.id}" class="btn-accion-modal">
                            <i class="fas fa-notes-medical"></i> Historia Clínica
                        </a>
                        <a href="/laboratorio/orden/crear/${data.id}" class="btn-accion-modal">
                            <i class="fas fa-flask"></i> Orden de Laboratorio
                        </a>
                    </div>
                </div>
            `;
        });
}

// Cerrar modal
document.querySelector('.close-modal').addEventListener('click', function() {
    document.getElementById('pacienteModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    const modal = document.getElementById('pacienteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
</script>
@endpush