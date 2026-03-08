@extends('layouts.app')

@section('page-title', 'Historia Clínica Pediátrica')
@section('title', 'Historia Pediátrica')

@section('content')
<div class="dashboard-card" style="max-width: 1200px; margin: 0 auto;">
    <div class="card-header">
        <h3><i class="fas fa-child"></i> Historia Clínica Pediátrica #{{ $historia->id }}</h3>
        <a href="{{ route('historias.index', $historia->paciente->id) }}" class="btn-add">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="card-body">
        <div class="detalle-paciente">
            <!-- Cabecera del paciente -->
            <div class="detalle-header">
                <div class="detalle-avatar" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    {{ substr($historia->paciente->nombre, 0, 1) }}{{ substr($historia->paciente->apellido, 0, 1) }}
                </div>
                <div class="detalle-titulo">
                    <h2>{{ $historia->paciente->nombre_completo }}</h2>
                    <p><i class="fas fa-calendar-alt"></i> Fecha de consulta: {{ $historia->fecha->format('d/m/Y') }}</p>
                    <p><i class="fas fa-baby"></i> Edad: {{ $historia->edad_meses }} meses ({{ $historia->paciente->edad }} años)</p>
                </div>
            </div>

            <!-- DATOS DEL MÉDICO -->
            <div class="detalle-seccion">
                <h3><i class="fas fa-user-md"></i> Médico</h3>
                <p>Dr. {{ $historia->doctor->nombre ?? 'No asignado' }}</p>
            </div>

            <!-- DATOS PERINATALES -->
            <div class="detalle-grid">
                <div class="detalle-seccion">
                    <h3><i class="fas fa-pregnancy"></i> Antecedentes Perinatales</h3>
                    <p><strong>Gestión (semanas):</strong> {{ $historia->gestacion_semanas ?? 'N/E' }}</p>
                    <p><strong>Tipo de parto:</strong> {{ $historia->parto_tipo ?? 'N/E' }}</p>
                    <p><strong>Peso al nacer:</strong> {{ $historia->peso_nacer ?? 'N/E' }} kg</p>
                    <p><strong>Talla al nacer:</strong> {{ $historia->talla_nacer ?? 'N/E' }} cm</p>
                    <p><strong>Perímetro cefálico:</strong> {{ $historia->perimetro_cefalico_nacer ?? 'N/E' }} cm</p>
                    <p><strong>Apgar 1 min:</strong> {{ $historia->apgar_1min ?? 'N/E' }}</p>
                    <p><strong>Apgar 5 min:</strong> {{ $historia->apgar_5min ?? 'N/E' }}</p>
                    <p><strong>Lactancia materna:</strong> {{ $historia->lactancia_materna ?? 'N/E' }}</p>
                </div>

                <!-- DESARROLLO PSICOMOTOR -->
                <div class="detalle-seccion">
                    <h3><i class="fas fa-brain"></i> Desarrollo Psicomotor</h3>
                    <p><strong>Sostiene cabeza:</strong> {{ $historia->sostiene_cabeza_meses ?? 'N/E' }} meses</p>
                    <p><strong>Se sienta solo:</strong> {{ $historia->se_sienta_meses ?? 'N/E' }} meses</p>
                    <p><strong>Gatea:</strong> {{ $historia->gatea_meses ?? 'N/E' }} meses</p>
                    <p><strong>Camina solo:</strong> {{ $historia->camina_meses ?? 'N/E' }} meses</p>
                    <p><strong>Primeras palabras:</strong> {{ $historia->primeras_palabras_meses ?? 'N/E' }} meses</p>
                    <p><strong>Control de esfínteres:</strong> {{ $historia->control_esfinteres ?? 'N/E' }}</p>
                </div>
            </div>

            <!-- VACUNAS -->
            <div class="detalle-seccion">
                <h3><i class="fas fa-syringe"></i> Vacunas Aplicadas</h3>
                @if($historia->vacunasAplicadas && count($historia->vacunasAplicadas) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vacuna</th>
                                <th>Dosis</th>
                                <th>Fecha</th>
                                <th>Lote</th>
                                <th>Establecimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historia->vacunasAplicadas as $vacuna)
                            <tr>
                                <td>{{ $vacuna->vacuna }}</td>
                                <td>{{ $vacuna->dosis ?? 'N/E' }}</td>
                                <td>{{ $vacuna->fecha_aplicacion ? $vacuna->fecha_aplicacion->format('d/m/Y') : 'N/E' }}</td>
                                <td>{{ $vacuna->lote ?? 'N/E' }}</td>
                                <td>{{ $vacuna->establecimiento ?? 'N/E' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay vacunas registradas</p>
                @endif
            </div>

            <!-- EXAMEN FÍSICO ACTUAL -->
            <div class="detalle-grid">
                <div class="detalle-seccion">
                    <h3><i class="fas fa-weight-scale"></i> Medidas Actuales</h3>
                    <p><strong>Peso:</strong> {{ $historia->peso_actual ?? 'N/E' }} kg</p>
                    <p><strong>Talla:</strong> {{ $historia->talla_actual ?? 'N/E' }} cm</p>
                    <p><strong>Perímetro cefálico:</strong> {{ $historia->perimetro_cefalico_actual ?? 'N/E' }} cm</p>
                    <p><strong>Percentil peso:</strong> {{ $historia->percentil_peso ?? 'N/E' }}</p>
                    <p><strong>Percentil talla:</strong> {{ $historia->percentil_talla ?? 'N/E' }}</p>
                    <p><strong>Percentil PC:</strong> {{ $historia->percentil_pc ?? 'N/E' }}</p>
                </div>

                <div class="detalle-seccion">
                    <h3><i class="fas fa-heartbeat"></i> Signos Vitales</h3>
                    <p><strong>Temperatura:</strong> {{ $historia->temperatura ?? 'N/E' }} °C</p>
                    <p><strong>Frec. Cardíaca:</strong> {{ $historia->frecuencia_cardiaca ?? 'N/E' }} lpm</p>
                    <p><strong>Frec. Respiratoria:</strong> {{ $historia->frecuencia_respiratoria ?? 'N/E' }} rpm</p>
                </div>
            </div>

            <!-- DIAGNÓSTICO Y TRATAMIENTO -->
            <div class="detalle-seccion">
                <h3><i class="fas fa-diagnoses"></i> Diagnóstico</h3>
                <p>{{ $historia->diagnostico ?? 'No especificado' }}</p>
            </div>

            <div class="detalle-seccion">
                <h3><i class="fas fa-pills"></i> Tratamiento</h3>
                <p>{{ $historia->tratamiento ?? 'No especificado' }}</p>
            </div>

            @if($historia->observaciones)
            <div class="detalle-seccion">
                <h3><i class="fas fa-comment"></i> Observaciones</h3>
                <p>{{ $historia->observaciones }}</p>
            </div>
            @endif

            @if($historia->proxima_cita)
            <div class="detalle-seccion" style="background: #d4edda;">
                <h3><i class="fas fa-calendar-check"></i> Próxima Cita</h3>
                <p>{{ $historia->proxima_cita->format('d/m/Y') }}</p>
            </div>
            @endif

            <!-- BOTONES DE ACCIÓN -->
            <div class="detalle-acciones" style="margin-top: 30px;">
                <a href="{{ route('historias.index', $historia->paciente->id) }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection