@extends('layouts.app')

@section('page-title', 'Nueva Historia Clínica Pediátrica')
@section('title', 'Historia Pediátrica')

@section('content')
<div class="form-container" style="max-width: 1000px;">
    <form action="{{ route('historias.pediatrica.store') }}" method="POST" class="medical-form">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        
        <div class="form-header">
            <h2><i class="fas fa-child"></i> Nueva Historia Clínica Pediátrica</h2>
            <p>Paciente: <strong>{{ $paciente->nombre_completo }}</strong> ({{ $paciente->edad }} años)</p>
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

        <!-- Fecha de consulta -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-calendar-alt"></i> Fecha de Consulta</h3>
            <div class="form-group">
                <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
            </div>
        </div>

        <!-- Motivo y enfermedad actual -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-notes-medical"></i> Motivo de Consulta</h3>
            <div class="form-group">
                <textarea name="motivo_consulta" rows="2" placeholder="¿Por qué consulta?" required>{{ old('motivo_consulta') }}</textarea>
            </div>

            <h3 class="section-title" style="margin-top: 15px;"><i class="fas fa-thermometer-half"></i> Enfermedad Actual</h3>
            <div class="form-group">
                <textarea name="enfermedad_actual" rows="3" placeholder="Descripción detallada...">{{ old('enfermedad_actual') }}</textarea>
            </div>
        </div>

        <!-- Antecedentes perinatales -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-pregnancy"></i> Antecedentes Perinatales</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Semanas de gestación</label>
                    <input type="number" name="gestacion_semanas" value="{{ old('gestacion_semanas') }}">
                </div>
                
                <div class="form-group">
                    <label>Tipo de parto</label>
                    <select name="parto_tipo">
                        <option value="">Seleccionar</option>
                        <option value="vaginal" {{ old('parto_tipo') == 'vaginal' ? 'selected' : '' }}>Vaginal</option>
                        <option value="cesarea" {{ old('parto_tipo') == 'cesarea' ? 'selected' : '' }}>Cesárea</option>
                        <option value="forceps" {{ old('parto_tipo') == 'forceps' ? 'selected' : '' }}>Fórceps</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Peso al nacer (kg)</label>
                    <input type="number" step="0.01" name="peso_nacer" value="{{ old('peso_nacer') }}">
                </div>
                
                <div class="form-group">
                    <label>Talla al nacer (cm)</label>
                    <input type="number" step="0.1" name="talla_nacer" value="{{ old('talla_nacer') }}">
                </div>
                
                <div class="form-group">
                    <label>Perímetro cefálico (cm)</label>
                    <input type="number" step="0.1" name="perimetro_cefalico_nacer" value="{{ old('perimetro_cefalico_nacer') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Apgar 1 min</label>
                    <input type="number" name="apgar_1min" min="0" max="10" value="{{ old('apgar_1min') }}">
                </div>
                
                <div class="form-group">
                    <label>Apgar 5 min</label>
                    <input type="number" name="apgar_5min" min="0" max="10" value="{{ old('apgar_5min') }}">
                </div>
                
                <div class="form-group">
                    <label>Lactancia materna</label>
                    <select name="lactancia_materna">
                        <option value="">Seleccionar</option>
                        <option value="exclusiva" {{ old('lactancia_materna') == 'exclusiva' ? 'selected' : '' }}>Exclusiva</option>
                        <option value="mixta" {{ old('lactancia_materna') == 'mixta' ? 'selected' : '' }}>Mixta</option>
                        <option value="artificial" {{ old('lactancia_materna') == 'artificial' ? 'selected' : '' }}>Artificial</option>
                        <option value="destete" {{ old('lactancia_materna') == 'destete' ? 'selected' : '' }}>Destete</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Desarrollo psicomotor -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-brain"></i> Desarrollo Psicomotor (edad en meses)</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Sostiene cabeza</label>
                    <input type="number" name="sostiene_cabeza_meses" value="{{ old('sostiene_cabeza_meses') }}">
                </div>
                
                <div class="form-group">
                    <label>Se sienta solo</label>
                    <input type="number" name="se_sienta_meses" value="{{ old('se_sienta_meses') }}">
                </div>
                
                <div class="form-group">
                    <label>Gatea</label>
                    <input type="number" name="gatea_meses" value="{{ old('gatea_meses') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Camina solo</label>
                    <input type="number" name="camina_meses" value="{{ old('camina_meses') }}">
                </div>
                
                <div class="form-group">
                    <label>Primeras palabras</label>
                    <input type="number" name="primeras_palabras_meses" value="{{ old('primeras_palabras_meses') }}">
                </div>
                
                <div class="form-group">
                    <label>Control de esfínteres</label>
                    <input type="text" name="control_esfinteres" placeholder="Ej: Diurno, nocturno, etc" value="{{ old('control_esfinteres') }}">
                </div>
            </div>
        </div>

        <!-- Vacunas -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-syringe"></i> Vacunas Aplicadas</h3>
            
            <div id="vacunas-list">
                <div class="vacuna-row" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: flex-end;">
                    <div style="flex: 2;">
                        <label>Vacuna</label>
                        <input type="text" name="vacunas[0][vacuna]" placeholder="Ej: BCG, Pentavalente, etc">
                    </div>
                    <div style="flex: 1;">
                        <label>Dosis</label>
                        <input type="text" name="vacunas[0][dosis]" placeholder="Ej: 1ra, 2da">
                    </div>
                    <div style="flex: 1;">
                        <label>Fecha</label>
                        <input type="date" name="vacunas[0][fecha_aplicacion]">
                    </div>
                    <div style="flex: 1;">
                        <label>Lote</label>
                        <input type="text" name="vacunas[0][lote]">
                    </div>
                    <div style="flex: 1;">
                        <label>Establecimiento</label>
                        <input type="text" name="vacunas[0][establecimiento]">
                    </div>
                    <button type="button" class="btn-remove-row" onclick="this.closest('.vacuna-row').remove()" style="flex: 0;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <button type="button" id="add-vacuna" class="btn-add-row">
                <i class="fas fa-plus"></i> Agregar otra vacuna
            </button>
        </div>

        <!-- Examen físico actual -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-weight-scale"></i> Examen Físico Actual</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Peso actual (kg)</label>
                    <input type="number" step="0.01" name="peso_actual" value="{{ old('peso_actual') }}">
                </div>
                
                <div class="form-group">
                    <label>Talla actual (cm)</label>
                    <input type="number" step="0.1" name="talla_actual" value="{{ old('talla_actual') }}">
                </div>
                
                <div class="form-group">
                    <label>Perímetro cefálico (cm)</label>
                    <input type="number" step="0.1" name="perimetro_cefalico_actual" value="{{ old('perimetro_cefalico_actual') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Percentil peso</label>
                    <input type="number" name="percentil_peso" value="{{ old('percentil_peso') }}">
                </div>
                
                <div class="form-group">
                    <label>Percentil talla</label>
                    <input type="number" name="percentil_talla" value="{{ old('percentil_talla') }}">
                </div>
                
                <div class="form-group">
                    <label>Percentil PC</label>
                    <input type="number" name="percentil_pc" value="{{ old('percentil_pc') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Temperatura (°C)</label>
                    <input type="number" step="0.1" name="temperatura" value="{{ old('temperatura') }}">
                </div>
                
                <div class="form-group">
                    <label>Frec. Cardíaca</label>
                    <input type="number" name="frecuencia_cardiaca" value="{{ old('frecuencia_cardiaca') }}">
                </div>
                
                <div class="form-group">
                    <label>Frec. Respiratoria</label>
                    <input type="number" name="frecuencia_respiratoria" value="{{ old('frecuencia_respiratoria') }}">
                </div>
            </div>
        </div>

        <!-- Diagnóstico y tratamiento -->
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-diagnoses"></i> Diagnóstico</h3>
            <div class="form-group">
                <textarea name="diagnostico" rows="2" required>{{ old('diagnostico') }}</textarea>
            </div>

            <h3 class="section-title" style="margin-top: 15px;"><i class="fas fa-pills"></i> Tratamiento</h3>
            <div class="form-group">
                <textarea name="tratamiento" rows="3">{{ old('tratamiento') }}</textarea>
            </div>

            <h3 class="section-title" style="margin-top: 15px;"><i class="fas fa-comment"></i> Observaciones</h3>
            <div class="form-group">
                <textarea name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
            </div>

            <h3 class="section-title" style="margin-top: 15px;"><i class="fas fa-calendar-check"></i> Próxima cita</h3>
            <div class="form-group">
                <input type="date" name="proxima_cita" value="{{ old('proxima_cita') }}">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Historia Pediátrica
            </button>
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script>
let vacunaIndex = 1;

document.getElementById('add-vacuna').addEventListener('click', function() {
    const list = document.getElementById('vacunas-list');
    const newRow = document.querySelector('.vacuna-row').cloneNode(true);
    
    // Actualizar índices
    newRow.innerHTML = newRow.innerHTML.replace(/vacunas\[0\]/g, `vacunas[${vacunaIndex}]`);
    
    // Limpiar valores
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    
    list.appendChild(newRow);
    vacunaIndex++;
});
</script>
@endsection