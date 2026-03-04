@extends('layouts.app')

@section('page-title', 'Gestión de Pacientes')
@section('title', 'Pacientes')

@section('content')
<!-- Hero Section -->
<div class="pacientes-hero">
    <div class="hero-content">
        <h1><i class="fas fa-users"></i> Gestión de Pacientes</h1>
        <p>Administra la información médica de todos tus pacientes de manera eficiente y profesional</p>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $totalPacientes }}</span>
                <span class="stat-label">Total</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $hombres }}</span>
                <span class="stat-label">Hombres</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $mujeres }}</span>
                <span class="stat-label">Mujeres</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $adultosMayores }}</span>
                <span class="stat-label">+60</span>
            </div>
        </div>
    </div>
    <div class="hero-image">
        <i class="fas fa-user-md"></i>
    </div>
</div>

<!-- Barra de herramientas -->
<div class="pacientes-toolbar">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscarPaciente" placeholder="Buscar paciente por nombre, email o teléfono...">
        <div class="search-spinner" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>
    
    <div class="toolbar-actions">
        <!-- BOTONES DE EXPORTACIÓN AGREGADOS -->
        <div class="btn-group" style="display: flex; gap: 5px; margin-right: 10px;">
            <a href="{{ route('exportar.pacientes.excel') }}" class="btn-view" title="Exportar a Excel">
                <i class="fas fa-file-excel" style="color: #28a745;"></i>
            </a>
            <a href="{{ route('exportar.pacientes.pdf') }}" class="btn-view" title="Exportar a PDF">
                <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
            </a>
        </div>
        
        <div class="view-toggle">
            <button class="btn-view active" data-view="grid">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="btn-view" data-view="list">
                <i class="fas fa-list"></i>
            </button>
        </div>
        
        <a href="{{ route('pacientes.create') }}" class="btn-nuevo-paciente">
            <i class="fas fa-plus-circle"></i>
            Nuevo Paciente
        </a>
    </div>
</div>

<!-- Filtros rápidos -->
<div class="filtros-rapidos">
    <span class="filtro-label">Filtrar por:</span>
    <button class="filtro-btn active" data-filter="todos">Todos</button>
    <button class="filtro-btn" data-filter="hombre">Hombres</button>
    <button class="filtro-btn" data-filter="mujer">Mujeres</button>
    <button class="filtro-btn" data-filter="mayor60">Mayores 60</button>
    <button class="filtro-btn" data-filter="sangre-a">Tipo A+</button>
</div>

<!-- Contenedor de resultados -->
<div id="pacientes-container" class="pacientes-grid">
    @foreach($pacientes as $paciente)
    <div class="paciente-card" data-paciente-id="{{ $paciente->id }}" 
         data-genero="{{ $paciente->genero }}"
         data-edad="{{ $paciente->edad }}"
         data-sangre="{{ $paciente->tipo_sangre }}">
        
        <div class="card-header">
            @php
                $iniciales = strtoupper(substr($paciente->nombre, 0, 1) . substr($paciente->apellido, 0, 1));
                $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            @endphp
            <div class="paciente-avatar" style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}80);">
                <span>{{ $iniciales }}</span>
            </div>
            <div class="paciente-info-header">
                <h3>{{ $paciente->nombre }} {{ $paciente->apellido }}</h3>
                <span class="paciente-edad">{{ $paciente->edad }} años</span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="info-row">
                <i class="fas fa-envelope"></i>
                <span>{{ $paciente->email ?? 'No especificado' }}</span>
            </div>
            <div class="info-row">
                <i class="fas fa-phone"></i>
                <span>{{ $paciente->telefono ?? 'No especificado' }}</span>
            </div>
            <div class="info-row">
                <i class="fas fa-tint"></i>
                <span>Tipo sangre: <strong>{{ $paciente->tipo_sangre ?? 'N/E' }}</strong></span>
            </div>
            @if(!empty($paciente->alergias))
            <div class="info-row alerta-alergia">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Alergias: {{ Str::limit($paciente->alergias, 30) }}</span>
            </div>
            @endif
        </div>
        
        <div class="card-footer">
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-accion" style="color: var(--primary);">
                <i class="fas fa-notes-medical"></i> Historias
            </a>
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn-accion editar">
                <i class="fas fa-edit"></i> Editar
            </a>
            <button class="btn-accion eliminar" onclick="eliminarPaciente({{ $paciente->id }})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    @endforeach
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
// Variables globales
let vistaActual = 'grid';

// Cambiar entre vista grid y lista
document.querySelectorAll('.btn-view').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.btn-view').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        vistaActual = this.dataset.view;
        const container = document.getElementById('pacientes-container');
        
        if (vistaActual === 'grid') {
            container.className = 'pacientes-grid';
        } else {
            container.className = 'pacientes-list';
        }
    });
});

// Búsqueda en tiempo real
const searchInput = document.getElementById('buscarPaciente');
const searchSpinner = document.querySelector('.search-spinner');

searchInput.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    
    if (term.length > 0) {
        searchSpinner.style.display = 'inline-block';
        
        setTimeout(() => {
            filtrarPacientes(term);
            searchSpinner.style.display = 'none';
        }, 500);
    } else {
        document.querySelectorAll('.paciente-card').forEach(card => {
            card.style.display = 'block';
        });
    }
});

function filtrarPacientes(term) {
    document.querySelectorAll('.paciente-card').forEach(card => {
        const nombre = card.querySelector('h3').textContent.toLowerCase();
        const email = card.querySelector('.info-row .fa-envelope + span').textContent.toLowerCase();
        const telefono = card.querySelector('.info-row .fa-phone + span').textContent.toLowerCase();
        
        if (nombre.includes(term) || email.includes(term) || telefono.includes(term)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Filtros rápidos
document.querySelectorAll('.filtro-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filtro = this.dataset.filter;
        
        document.querySelectorAll('.paciente-card').forEach(card => {
            switch(filtro) {
                case 'todos':
                    card.style.display = 'block';
                    break;
                case 'hombre':
                    card.style.display = card.dataset.genero === 'M' ? 'block' : 'none';
                    break;
                case 'mujer':
                    card.style.display = card.dataset.genero === 'F' ? 'block' : 'none';
                    break;
                case 'mayor60':
                    card.style.display = parseInt(card.dataset.edad) >= 60 ? 'block' : 'none';
                    break;
                case 'sangre-a':
                    card.style.display = card.dataset.sangre === 'A+' ? 'block' : 'none';
                    break;
            }
        });
    });
});

// Ver detalle del paciente
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

// Eliminar paciente
function eliminarPaciente(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e55039',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/pacientes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El paciente ha sido eliminado.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar el paciente',
                        'error'
                    );
                }
            });
        }
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