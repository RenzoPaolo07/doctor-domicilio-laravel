@extends('layouts.app')

@section('page-title', 'Nuevo Paciente')
@section('title', 'Crear Paciente')

@section('content')
<div class="form-container">
    <form action="{{ route('pacientes.store') }}" method="POST" enctype="multipart/form-data" class="medical-form">
        @csrf
        
        <div class="form-header">
            <h2><i class="fas fa-user-plus"></i> Registrar Nuevo Paciente</h2>
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

        <div class="form-progress">
            <div class="progress-step active" data-step="1">
                <span class="step-number">1</span>
                <span class="step-label">Datos Personales</span>
            </div>
            <div class="progress-step" data-step="2">
                <span class="step-number">2</span>
                <span class="step-label">Contacto</span>
            </div>
            <div class="progress-step" data-step="3">
                <span class="step-number">3</span>
                <span class="step-label">Información Médica</span>
            </div>
            <div class="progress-step" data-step="4">
                <span class="step-number">4</span>
                <span class="step-label">Emergencia</span>
            </div>
        </div>

        <!-- PASO 1: Datos Personales -->
        <div class="form-step active" id="step1">
            <div class="step-header">
                <h3><i class="fas fa-user"></i> Datos Personales</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Apellido *</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-venus-mars"></i> Género</label>
                    <select name="genero">
                        <option value="">Seleccionar</option>
                        <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-camera"></i> Foto del Paciente</label>
                <div class="file-upload">
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <label for="foto" class="file-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Seleccionar archivo</span>
                    </label>
                    <div class="file-preview" id="filePreview"></div>
                </div>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-next" onclick="nextStep(2)">Siguiente <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- PASO 2: Contacto -->
        <div class="form-step" id="step2">
            <div class="step-header">
                <h3><i class="fas fa-address-book"></i> Información de Contacto</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Teléfono</label>
                    <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="+51 999 888 777">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
                <textarea name="direccion" rows="2" placeholder="Calle, número, urbanización...">{{ old('direccion') }}</textarea>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevStep(1)"><i class="fas fa-arrow-left"></i> Anterior</button>
                <button type="button" class="btn-next" onclick="nextStep(3)">Siguiente <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- PASO 3: Información Médica -->
        <div class="form-step" id="step3">
            <div class="step-header">
                <h3><i class="fas fa-heartbeat"></i> Información Médica</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-tint"></i> Tipo de Sangre</label>
                    <select name="tipo_sangre">
                        <option value="">Seleccionar</option>
                        <option value="A+" {{ old('tipo_sangre') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('tipo_sangre') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('tipo_sangre') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('tipo_sangre') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="O+" {{ old('tipo_sangre') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('tipo_sangre') == 'O-' ? 'selected' : '' }}>O-</option>
                        <option value="AB+" {{ old('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB-</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-allergies"></i> Alergias</label>
                <textarea name="alergias" rows="3" placeholder="Especificar alergias a medicamentos, alimentos, etc.">{{ old('alergias') }}</textarea>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Anterior</button>
                <button type="button" class="btn-next" onclick="nextStep(4)">Siguiente <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- PASO 4: Contacto de Emergencia -->
        <div class="form-step" id="step4">
            <div class="step-header">
                <h3><i class="fas fa-phone-alt"></i> Contacto de Emergencia</h3>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nombre del Contacto</label>
                    <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}" placeholder="Nombre completo">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Teléfono de Emergencia</label>
                    <input type="tel" name="telefono_emergencia" value="{{ old('telefono_emergencia') }}" placeholder="+51 999 888 777">
                </div>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Anterior</button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Guardar Paciente
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Navegación entre pasos
let currentStep = 1;

function nextStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.progress-step').forEach(el => el.classList.remove('active'));
    
    document.getElementById(`step${step}`).classList.add('active');
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.add('active');
    
    currentStep = step;
}

function prevStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.progress-step').forEach(el => el.classList.remove('active'));
    
    document.getElementById(`step${step}`).classList.add('active');
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.add('active');
    
    currentStep = step;
}

// Vista previa de imagen
document.getElementById('foto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('filePreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});
</script>
@endsection