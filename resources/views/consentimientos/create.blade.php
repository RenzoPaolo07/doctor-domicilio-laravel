@extends('layouts.app')

@section('page-title', 'Nuevo Consentimiento Informado')
@section('title', 'Crear Consentimiento')

@section('content')
<div class="form-container">
    <form action="{{ route('consentimientos.store') }}" method="POST" class="medical-form">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        
        <div class="form-header">
            <h2><i class="fas fa-file-signature"></i> Consentimiento Informado</h2>
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
                <label>Fecha del Consentimiento *</label>
                <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label>Procedimiento / Tratamiento *</label>
                <textarea name="procedimiento" rows="4" placeholder="Describa el procedimiento, riesgos, beneficios, etc..." required>{{ old('procedimiento') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label>Testigos (opcional)</label>
                <textarea name="testigos" rows="2" placeholder="Nombres de los testigos presentes">{{ old('testigos') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-pen"></i> Firma Digital
            </h3>
            <p>Dibuje su firma en el recuadro:</p>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <canvas id="signatureCanvas" width="500" height="200" style="border: 2px solid #4a69bd; border-radius: 10px; background: #fff;"></canvas>
            </div>
            
            <input type="hidden" name="firma_digital" id="firmaInput" required>
            
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 10px;">
                <button type="button" id="clearSignature" class="btn-cancel" style="padding: 8px 20px;">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Consentimiento
            </button>
            <a href="{{ route('historias.index', $paciente->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script>
const canvas = document.getElementById('signatureCanvas');
const ctx = canvas.getContext('2d');
let drawing = false;
let lastX = 0;
let lastY = 0;

// Configurar el estilo del dibujo
ctx.strokeStyle = '#2c3e50';
ctx.lineWidth = 2;
ctx.lineCap = 'round';
ctx.lineJoin = 'round';

// Eventos para dibujar
canvas.addEventListener('mousedown', (e) => {
    drawing = true;
    [lastX, lastY] = [e.offsetX, e.offsetY];
});

canvas.addEventListener('mousemove', (e) => {
    if (!drawing) return;
    
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
    
    [lastX, lastY] = [e.offsetX, e.offsetY];
});

canvas.addEventListener('mouseup', () => {
    drawing = false;
    // Guardar la firma en el input oculto
    document.getElementById('firmaInput').value = canvas.toDataURL();
});

canvas.addEventListener('mouseleave', () => {
    drawing = false;
});

// Botón para limpiar
document.getElementById('clearSignature').addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('firmaInput').value = '';
});

// Soporte táctil para dispositivos móviles
canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    const rect = canvas.getBoundingClientRect();
    lastX = touch.clientX - rect.left;
    lastY = touch.clientY - rect.top;
    drawing = true;
});

canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    if (!drawing) return;
    
    const touch = e.touches[0];
    const rect = canvas.getBoundingClientRect();
    const x = touch.clientX - rect.left;
    const y = touch.clientY - rect.top;
    
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    
    lastX = x;
    lastY = y;
});

canvas.addEventListener('touchend', (e) => {
    e.preventDefault();
    drawing = false;
    document.getElementById('firmaInput').value = canvas.toDataURL();
});
</script>
@endsection