@extends('layouts.app')

@section('page-title', 'Panel de Control')
@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
@endpush

@section('content')
<!-- Tarjetas de estadísticas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalPacientes }}</h3>
            <p>Total Pacientes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $proximasCitas->count() }}</h3>
            <p>Próximas Citas</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-info">
            <h3>S/ {{ number_format($ingresosMes, 2) }}</h3>
            <p>Ingresos del Mes</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $boletasPendientes }}</h3>
            <p>Pagos Pendientes</p>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="dashboard-grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 20px;">
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-chart-pie"></i> Pacientes por Edad</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoEdad" style="height: 250px;"></canvas>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-tint"></i> Tipo de Sangre</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoSangre" style="height: 250px;"></canvas>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <h3><i class="fas fa-calendar-alt"></i> Próximas Citas</h3>
            <a href="{{ route('calendario.index') }}" class="btn-add">Ver Calendario</a>
        </div>
        <div class="card-body">
            <ul class="activity-list">
                @forelse($proximasCitas as $cita)
                <li>
                    <i class="fas fa-calendar-check activity-icon" style="background: #4facfe;"></i>
                    <div>
                        <p><strong>{{ $cita->paciente->nombre_completo }}</strong> - {{ $cita->motivo_consulta ?? 'Consulta' }}</p>
                        <small>{{ $cita->proxima_cita->format('d/m/Y') }}</small>
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
                    <td>{{ $paciente->email ?? 'N/E' }}</td>
                    <td>{{ $paciente->telefono ?? 'N/E' }}</td>
                    <td>
                        <a href="{{ route('historias.index', $paciente->id) }}" class="btn-small">
                            <i class="fas fa-notes-medical"></i>
                        </a>
                        <a href="{{ route('recetas.create', $paciente->id) }}" class="btn-small">
                            <i class="fas fa-prescription"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
<script>
// Gráfico de edades
const ctxEdad = document.getElementById('graficoEdad').getContext('2d');
new Chart(ctxEdad, {
    type: 'pie',
    data: {
        labels: {!! json_encode($edades->pluck('rango')) !!},
        datasets: [{
            data: {!! json_encode($edades->pluck('total')) !!},
            backgroundColor: [
                '#667eea',
                '#f093fb',
                '#4facfe',
                '#43e97b',
                '#fa709a'
            ]
        }]
    }
});

// Gráfico de tipos de sangre
const ctxSangre = document.getElementById('graficoSangre').getContext('2d');
new Chart(ctxSangre, {
    type: 'bar',
    data: {
        labels: {!! json_encode($sangre->pluck('tipo_sangre')) !!},
        datasets: [{
            label: 'Pacientes',
            data: {!! json_encode($sangre->pluck('total')) !!},
            backgroundColor: '#4a69bd'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        }
    }
});
</script>
@endpush
@endsection