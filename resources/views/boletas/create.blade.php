@extends('layouts.app')

@section('page-title', 'Nueva Boleta')
@section('title', 'Crear Boleta')

@section('content')
<div class="form-container">
    <form action="{{ route('boletas.store') }}" method="POST" class="medical-form">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        
        <div class="form-header">
            <h2><i class="fas fa-file-invoice"></i> Nueva Boleta</h2>
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
            <div class="form-row">
                <div class="form-group">
                    <label>Fecha *</label>
                    <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Monto (S/) *</label>
                    <input type="number" name="monto" step="0.01" min="0" value="{{ old('monto') }}" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label>Concepto *</label>
                <textarea name="concepto" rows="3" placeholder="Descripción del servicio o producto..." required>{{ old('concepto') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <div class="form-row">
                <div class="form-group">
                    <label>Método de Pago *</label>
                    <select name="metodo_pago" required>
                        <option value="">Seleccionar</option>
                        <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        <option value="otro" {{ old('metodo_pago') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Estado *</label>
                    <select name="estado" required>
                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ old('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="anulado" {{ old('estado') == 'anulado' ? 'selected' : '' }}>Anulado</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Generar Boleta
            </button>
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection