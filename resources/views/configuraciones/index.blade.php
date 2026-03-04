@extends('layouts.app')

@section('page-title', 'Configuraciones del Sistema')
@section('title', 'Configuraciones')

@section('content')
<div class="form-container" style="max-width: 800px;">
    <div class="form-header">
        <h2><i class="fas fa-cog"></i> Configuraciones del Sistema</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('configuraciones.update') }}" method="POST">
        @csrf
        
        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-globe"></i> Información General</h3>
            
            <div class="form-group">
                <label>Nombre del Sitio</label>
                <input type="text" name="sitio_nombre" value="{{ Configuracion::get('sitio_nombre', 'Doctor Domicilio') }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="sitio_descripcion" rows="2" class="form-control">{{ Configuracion::get('sitio_descripcion', 'Sistema de Gestión Clínica') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-phone"></i> Información de Contacto</h3>
            
            <div class="form-group">
                <label>Email de Contacto</label>
                <input type="email" name="email_contacto" value="{{ Configuracion::get('email_contacto', 'info@doctordomicilio.com') }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono_contacto" value="{{ Configuracion::get('telefono_contacto', '+51 999 888 777') }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ Configuracion::get('direccion', 'Av. Principal 123') }}" class="form-control">
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title"><i class="fas fa-dollar-sign"></i> Facturación</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Símbolo de Moneda</label>
                    <input type="text" name="moneda" value="{{ Configuracion::get('moneda', 'S/') }}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Impuesto (%)</label>
                    <input type="number" name="impuesto" value="{{ Configuracion::get('impuesto', '18') }}" class="form-control" step="0.01" min="0" max="100">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar Configuraciones
            </button>
            <a href="{{ route('configuraciones.reset') }}" class="btn-cancel" onclick="return confirm('¿Restaurar valores por defecto?')">
                <i class="fas fa-undo"></i> Restaurar
            </a>
        </div>
    </form>
</div>
@endsection