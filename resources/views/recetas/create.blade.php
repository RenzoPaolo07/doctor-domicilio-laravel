@extends('layouts.app')

@section('page-title', 'Nueva Receta Médica')
@section('title', 'Crear Receta')

@section('content')
<div class="form-container">
    <form action="{{ route('recetas.store') }}" method="POST" class="medical-form">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        
        <div class="form-header">
            <h2><i class="fas fa-prescription"></i> Nueva Receta Médica</h2>
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
            <h3 class="section-title">
                <i class="fas fa-calendar-alt"></i> Fecha de Emisión
            </h3>
            <div class="form-group">
                <input type="date" name="fecha_emision" value="{{ old('fecha_emision', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-stethoscope"></i> Diagnóstico
            </h3>
            <div class="form-group">
                <textarea name="diagnostico" rows="3" placeholder="Diagnóstico del paciente...">{{ old('diagnostico') }}</textarea>
            </div>
        </div>

        <div class="form-section" id="medicamentos-section">
            <h3 class="section-title">
                <i class="fas fa-pills"></i> Medicamentos Recetados
            </h3>
            
            <div id="medicamentos-list">
                <!-- Plantilla de medicamento -->
                <div class="medicamento-row">
                    <div class="form-group">
                        <label>Medicamento *</label>
                        <input type="text" name="medicamentos[0][medicamento]" placeholder="Ej: Amoxicilina" required>
                    </div>
                    <div class="form-group">
                        <label>Dosis</label>
                        <input type="text" name="medicamentos[0][dosis]" placeholder="Ej: 500mg">
                    </div>
                    <div class="form-group">
                        <label>Frecuencia</label>
                        <input type="text" name="medicamentos[0][frecuencia]" placeholder="Ej: Cada 8 horas">
                    </div>
                    <div class="form-group">
                        <label>Duración</label>
                        <input type="text" name="medicamentos[0][duracion]" placeholder="Ej: 7 días">
                    </div>
                    <button type="button" class="btn-remove-row" onclick="this.closest('.medicamento-row').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <button type="button" id="add-medicamento" class="btn-add-row">
                <i class="fas fa-plus"></i> Agregar otro medicamento
            </button>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-file-alt"></i> Indicaciones Adicionales
            </h3>
            <div class="form-group">
                <textarea name="indicaciones" rows="3" placeholder="Indicaciones para el paciente...">{{ old('indicaciones') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Receta
            </button>
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script>
let medicamentoIndex = 1;

document.getElementById('add-medicamento').addEventListener('click', function() {
    const list = document.getElementById('medicamentos-list');
    const newRow = document.querySelector('.medicamento-row').cloneNode(true);
    
    // Actualizar índices
    newRow.innerHTML = newRow.innerHTML.replace(/medicamentos\[0\]/g, `medicamentos[${medicamentoIndex}]`);
    
    // Limpiar valores
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    
    list.appendChild(newRow);
    medicamentoIndex++;
});
</script>
@endsection