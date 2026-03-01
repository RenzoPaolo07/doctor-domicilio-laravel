@extends('layouts.app')

@section('page-title', 'Nueva Orden de Laboratorio')
@section('title', 'Crear Orden')

@section('content')
<div class="form-container">
    <form action="{{ route('laboratorio.store') }}" method="POST" class="medical-form">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        
        <div class="form-header">
            <h2><i class="fas fa-flask"></i> Nueva Orden de Laboratorio</h2>
            <p>Paciente: <strong>{{ $paciente->nombre_completo }}</strong></p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-section">
            <div class="form-group">
                <label>Fecha de la Orden *</label>
                <input type="date" name="fecha_orden" value="{{ old('fecha_orden', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label>Exámenes Solicitados *</label>
                <textarea name="examenes_solicitados" rows="4" placeholder="Lista de exámenes a realizar..." required>{{ old('examenes_solicitados') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label>Indicaciones / Preparación</label>
                <textarea name="indicaciones" rows="3" placeholder="Indicaciones para el paciente (ayuno, etc)...">{{ old('indicaciones') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Generar Orden
            </button>
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection