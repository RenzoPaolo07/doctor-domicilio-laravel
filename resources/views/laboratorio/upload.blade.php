@extends('layouts.app')

@section('page-title', 'Subir Resultados')
@section('title', 'Resultados de Laboratorio')

@section('content')
<div class="form-container">
    <form action="{{ route('laboratorio.storeResultados', $orden->id) }}" method="POST" enctype="multipart/form-data" class="medical-form">
        @csrf
        
        <div class="form-header">
            <h2><i class="fas fa-file-pdf"></i> Subir Resultados de Laboratorio</h2>
            <p>Orden #{{ $orden->id }} - Paciente: <strong>{{ $orden->paciente->nombre_completo }}</strong></p>
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
            <h3>Exámenes Solicitados</h3>
            <div class="alert alert-info">
                {{ $orden->examenes_solicitados }}
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label><i class="fas fa-file-pdf"></i> Archivo PDF de Resultados *</label>
                <div class="file-upload">
                    <input type="file" name="archivo_resultado" id="archivo" accept=".pdf" required>
                    <label for="archivo" class="file-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Seleccionar archivo PDF</span>
                    </label>
                    <div class="file-preview" id="filePreview"></div>
                </div>
                <small class="text-muted">Máximo 10MB, solo archivos PDF</small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-upload"></i> Subir Resultados
            </button>
            <a href="{{ route('laboratorio.show', $orden->id) }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.getElementById('archivo')?.addEventListener('change', function(e) {
    const preview = document.getElementById('filePreview');
    const file = e.target.files[0];
    
    if (file) {
        preview.innerHTML = `
            <div style="padding: 10px; background: #e8f5e9; border-radius: 8px; margin-top: 10px;">
                <i class="fas fa-file-pdf" style="color: #f00;"></i>
                ${file.name} (${(file.size/1024).toFixed(2)} KB)
            </div>
        `;
    } else {
        preview.innerHTML = '';
    }
});
</script>
@endsection