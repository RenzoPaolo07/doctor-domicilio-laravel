@extends('layouts.app')

@section('page-title', 'Detalle de Consentimiento')
@section('title', 'Consentimiento Informado')

@section('content')
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-file-signature"></i> Consentimiento Informado #{{ $consentimiento->id }}</h3>
        <a href="{{ route('consentimientos.pdf', $consentimiento->id) }}" class="btn-add">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
    <div class="card-body">
        <div class="detalle-paciente">
            <div class="detalle-header">
                <div class="detalle-avatar" style="background: linear-gradient(135deg, #4a69bd, #6a89cc);">
                    {{ substr($consentimiento->paciente->nombre, 0, 1) }}{{ substr($consentimiento->paciente->apellido, 0, 1) }}
                </div>
                <div class="detalle-titulo">
                    <h2>{{ $consentimiento->paciente->nombre_completo }}</h2>
                    <p><i class="fas fa-calendar-alt"></i> Fecha: {{ $consentimiento->fecha->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="detalle-seccion" style="margin: 20px 0;">
                <h3><i class="fas fa-stethoscope"></i> Procedimiento</h3>
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; white-space: pre-line;">
                    {{ $consentimiento->procedimiento }}
                </div>
            </div>

            @if($consentimiento->testigos)
            <div class="detalle-seccion" style="margin: 20px 0;">
                <h3><i class="fas fa-users"></i> Testigos</h3>
                <p>{{ $consentimiento->testigos }}</p>
            </div>
            @endif

            <div class="detalle-seccion" style="margin: 20px 0;">
                <h3><i class="fas fa-pen"></i> Firma Digital</h3>
                <div style="text-align: center; background: #f8f9fa; padding: 20px; border-radius: 10px;">
                    <img src="{{ $consentimiento->firma_digital }}" alt="Firma" style="max-width: 300px; border: 1px solid #ddd;">
                </div>
            </div>

            <div class="detalle-acciones" style="margin-top: 30px;">
                <a href="{{ route('historias.index', $consentimiento->paciente->id) }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection