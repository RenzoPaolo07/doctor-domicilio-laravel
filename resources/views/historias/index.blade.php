@extends('layouts.app')

@section('page-title', 'Historias Clínicas de ' . $paciente->nombre_completo)
@section('title', 'Historias Clínicas')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ route('pacientes.index') }}">Pacientes</a>
    <i class="fas fa-chevron-right"></i>
    <span>Historias de {{ $paciente->nombre_completo }}</span>
</div>

<!-- Cabecera del paciente -->
<div class="paciente-info-header-historias">
    <div class="paciente-mini-card">
        <div class="mini-avatar" style="background: linear-gradient(135deg, #4a69bd, #6a89cc);">
            {{ substr($paciente->nombre, 0, 1) }}{{ substr($paciente->apellido, 0, 1) }}
        </div>
        <div class="mini-info">
            <h2>{{ $paciente->nombre_completo }}</h2>
            <p><i class="fas fa-calendar-alt"></i> {{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : 'N/E' }} ({{ $paciente->edad }} años)</p>
            <p><i class="fas fa-tint"></i> {{ $paciente->tipo_sangre ?? 'N/E' }}</p>
        </div>
    </div>
    
    <div class="paciente-actions">
        <a href="{{ route('historias.general.create', $paciente->id) }}" class="btn-action">
            <i class="fas fa-notes-medical"></i> Nueva Historia General
        </a>
        <a href="{{ route('historias.pediatrica.create', $paciente->id) }}" class="btn-action pediatrica">
            <i class="fas fa-child"></i> Nueva Historia Pediátrica
        </a>
        <a href="{{ route('pacientes.index') }}" class="btn-action secundario">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Tabs -->
<div class="historias-tabs">
    <button class="tab-btn active" onclick="showTab('generales')">
        <i class="fas fa-notes-medical"></i> Historias Generales
        <span class="tab-count">{{ $historias->count() }}</span>
    </button>
    <button class="tab-btn" onclick="showTab('pediatricas')">
        <i class="fas fa-child"></i> Historias Pediátricas
        <span class="tab-count">{{ $pediatricas->count() }}</span>
    </button>
</div>

<!-- Historias Generales -->
<div id="generales" class="tab-content active">
    @if($historias->count() > 0)
        <div class="historias-timeline">
            @foreach($historias as $historia)
                <div class="timeline-item">
                    <div class="timeline-date">
                        <span class="dia">{{ $historia->fecha->format('d') }}</span>
                        <span class="mes">{{ $historia->fecha->format('M') }}</span>
                        <span class="ano">{{ $historia->fecha->format('Y') }}</span>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <h3>{{ $historia->motivo_consulta ?? 'Consulta médica' }}</h3>
                            <span class="doctor-badge">
                                <i class="fas fa-user-md"></i> Dr. {{ $historia->doctor->nombre ?? 'No asignado' }}
                            </span>
                        </div>
                        <div class="timeline-diagnostico">
                            <strong>Diagnóstico:</strong> {{ Str::limit($historia->diagnostico ?? 'No especificado', 100) }}
                        </div>
                        <div class="timeline-footer">
                            <a href="{{ route('historias.general.show', $historia->id) }}" class="btn-ver">
                                <i class="fas fa-eye"></i> Ver detalles
                            </a>
                            @if($historia->proxima_cita)
                                <span class="proxima-cita">
                                    <i class="fas fa-calendar-check"></i> Próxima cita: {{ $historia->proxima_cita->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-notes-medical"></i>
            <h3>No hay historias clínicas generales</h3>
            <p>Comienza registrando la primera historia clínica para este paciente</p>
            <a href="{{ route('historias.general.create', $paciente->id) }}" class="btn-empty">
                <i class="fas fa-plus"></i> Crear primera historia
            </a>
        </div>
    @endif
</div>

<!-- Historias Pediátricas -->
<div id="pediatricas" class="tab-content">
    @if($pediatricas->count() > 0)
        <div class="pediatricas-grid">
            @foreach($pediatricas as $historia)
                <div class="pediatrica-card">
                    <div class="card-edad">
                        {{ $historia->edad_meses }} meses
                    </div>
                    <div class="card-medidas">
                        <div class="medida">
                            <i class="fas fa-weight-scale"></i>
                            <span>{{ $historia->peso_actual ?? '?' }} kg</span>
                        </div>
                        <div class="medida">
                            <i class="fas fa-ruler"></i>
                            <span>{{ $historia->talla_actual ?? '?' }} cm</span>
                        </div>
                    </div>
                    <div class="card-diagnostico">
                        <strong>Diagnóstico:</strong> {{ Str::limit($historia->diagnostico ?? 'No especificado', 60) }}
                    </div>
                    <div class="card-footer">
                        <span class="fecha"><i class="far fa-calendar"></i> {{ $historia->fecha->format('d/m/Y') }}</span>
                        <a href="{{ route('historias.pediatrica.show', $historia->id) }}" class="btn-ver">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-child"></i>
            <h3>No hay historias pediátricas</h3>
            <p>Este paciente no tiene registros pediátricos aún</p>
            <a href="{{ route('historias.pediatrica.create', $paciente->id) }}" class="btn-empty">
                <i class="fas fa-plus"></i> Crear historia pediátrica
            </a>
        </div>
    @endif
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    event.target.closest('.tab-btn').classList.add('active');
    document.getElementById(tabName).classList.add('active');
}
</script>
@endsection