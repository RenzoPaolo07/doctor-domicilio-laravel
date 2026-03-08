<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica #{{ $receta->id }}</title>
    <style>
        /* Estilos base para impresión/PDF */
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #000; 
            margin: 0; 
            padding: 20px; 
        }
        
        /* Header con logo y título */
        .header { 
            display: table; 
            width: 100%; 
            border-bottom: 4px solid #1a365d; 
            padding-bottom: 10px; 
            margin-bottom: 2px; 
        }
        .header-col { 
            display: table-cell; 
            vertical-align: middle; 
        }
        .logo { 
            width: 150px; 
        }
        .title-section { 
            text-align: center; 
            font-weight: bold; 
        }
        .qr-section { 
            text-align: right; 
            width: 100px; 
        }
        .qr-section img {
            width: 80px;
        }
        
        /* Línea roja decorativa */
        .red-line { 
            height: 4px; 
            background-color: #b91c1c; 
            width: 100%; 
            margin-bottom: 10px; 
        }
        
        /* Contenedor de dos columnas */
        .content { 
            display: table; 
            width: 100%; 
            margin-top: 10px; 
        }
        .col-left { 
            display: table-cell; 
            width: 48%; 
            padding-right: 2%; 
            border-right: 1px solid #ccc; 
        }
        .col-right { 
            display: table-cell; 
            width: 48%; 
            padding-left: 2%; 
        }
        
        /* Títulos de sección */
        .section-title { 
            background-color: #1a365d; 
            color: white; 
            text-align: center; 
            padding: 8px; 
            font-weight: bold; 
            font-size: 16px; 
            margin-bottom: 15px; 
            border-radius: 4px;
        }
        
        /* Estilo para la línea de receta médica (Rp:) */
        .rp-line {
            color: #b91c1c; 
            font-weight: bold; 
            font-size: 20px; 
            margin-bottom: 5px;
            font-style: italic;
        }
        
        /* Líneas punteadas para contenido */
        .line-input { 
            border-bottom: 1px dashed #999; 
            height: 25px; 
            width: 100%; 
            margin-bottom: 8px; 
        }
        
        /* Información del médico y paciente */
        .info-box {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #1a365d;
        }
        .info-row {
            margin-bottom: 5px;
            font-size: 12px;
        }
        .info-row strong {
            display: inline-block;
            width: 100px;
            color: #1a365d;
        }
        
        /* Tabla de medicamentos (para cuando hay datos) */
        .medicamentos-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }
        .medicamentos-table th {
            background: #1a365d;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }
        .medicamentos-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        
        /* Diagnóstico e indicaciones */
        .diagnostico-box, .indicaciones-box {
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        .diagnostico-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
        }
        .indicaciones-box {
            background: #d4edda;
            border-left: 5px solid #28a745;
        }
        
        /* Footer con firmas */
        .footer { 
            position: fixed; 
            bottom: 20px; 
            width: 100%; 
        }
        .signatures { 
            display: table; 
            width: 100%; 
            margin-top: 30px; 
            font-size: 12px; 
        }
        .sig-col { 
            display: table-cell; 
            width: 50%; 
        }
        .text-right { 
            text-align: right; 
        }
        
        /* Información de contacto */
        .footer-info { 
            background-color: #1a365d; 
            color: white; 
            text-align: center; 
            padding: 8px; 
            font-size: 11px; 
            margin-top: 20px; 
            border-radius: 4px;
        }
        
        /* Espaciadores */
        .spacer {
            height: 10px;
        }
    </style>
</head>
<body>

    <!-- HEADER con logo y título -->
    <div class="header">
        <div class="header-col">
            <img src="{{ public_path('img/logo.png') }}" alt="Doctor Domicilio" class="logo">
        </div>
        <div class="header-col title-section">
            <div style="font-size: 14px;">Atención médica en casa</div>
            <div style="font-size: 24px; color: #1a365d;">Receta Médica #{{ $receta->id }}</div>
        </div>
        <div class="header-col qr-section">
            <img src="{{ public_path('img/qr.png') }}" alt="QR" style="width: 80px;">
        </div>
    </div>
    <div class="red-line"></div>

    <!-- INFORMACIÓN DEL MÉDICO Y PACIENTE -->
    <div style="display: table; width: 100%; margin-bottom: 15px;">
        <div style="display: table-cell; width: 50%; padding-right: 10px;">
            <div class="info-box">
                <h4 style="margin: 0 0 8px 0; color: #1a365d;">Médico</h4>
                <div class="info-row"><strong>Nombre:</strong> Dr. {{ $receta->doctor->nombre ?? 'No especificado' }}</div>
                <div class="info-row"><strong>Email:</strong> {{ $receta->doctor->email ?? 'N/E' }}</div>
                <div class="info-row"><strong>CMP:</strong> _________________</div>
            </div>
        </div>
        <div style="display: table-cell; width: 50%; padding-left: 10px;">
            <div class="info-box">
                <h4 style="margin: 0 0 8px 0; color: #1a365d;">Paciente</h4>
                <div class="info-row"><strong>Nombre:</strong> {{ $receta->paciente->nombre_completo }}</div>
                <div class="info-row"><strong>Edad:</strong> {{ $receta->paciente->edad }} años</div>
                <div class="info-row"><strong>Fecha:</strong> {{ $receta->fecha_emision->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <!-- DIAGNÓSTICO (si existe) -->
    @if($receta->diagnostico)
    <div class="diagnostico-box">
        <strong>Diagnóstico:</strong> {{ $receta->diagnostico }}
    </div>
    @endif

    <!-- CONTENIDO PRINCIPAL: DOS COLUMNAS -->
    <div class="content">
        <!-- COLUMNA IZQUIERDA: MEDICAMENTOS -->
        <div class="col-left">
            <div class="section-title">Medicamentos Recetados</div>
            
            @if($receta->medicamentos && count($receta->medicamentos) > 0)
                <!-- Si hay medicamentos guardados, los mostramos en tabla -->
                <table class="medicamentos-table">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Dosis</th>
                            <th>Frecuencia</th>
                            <th>Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receta->medicamentos as $med)
                        <tr>
                            <td><strong>{{ $med->medicamento }}</strong></td>
                            <td>{{ $med->dosis ?? 'N/E' }}</td>
                            <td>{{ $med->frecuencia ?? 'N/E' }}</td>
                            <td>{{ $med->duracion ?? 'N/E' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <!-- Si no hay medicamentos guardados, mostramos líneas en blanco -->
                <div class="rp-line">Rp:</div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
            @endif
        </div>

        <!-- COLUMNA DERECHA: INDICACIONES -->
        <div class="col-right">
            <div class="section-title">Indicaciones</div>
            
            @if($receta->indicaciones)
                <div class="indicaciones-box">
                    {{ $receta->indicaciones }}
                </div>
                <!-- Espacio adicional para más indicaciones -->
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
            @else
                <div style="height: 10px;"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
                <div class="line-input"></div>
            @endif
        </div>
    </div>

    <!-- FIRMAS Y PIE DE PÁGINA -->
    <div class="footer">
        <div class="signatures">
            <div class="sig-col">
                <p>Médico tratante: <span style="border-bottom: 1px solid #000; padding: 0 20px;">Dr. {{ $receta->doctor->nombre ?? '_________________' }}</span></p>
                <p>CMP: <span style="border-bottom: 1px solid #000; padding: 0 20px;">_________________</span></p>
            </div>
            <div class="sig-col text-right">
                <p>Fecha: <span style="border-bottom: 1px solid #000; padding: 0 10px;">{{ $receta->fecha_emision->format('d/m/Y') }}</span></p>
                <br>
                <p>____________________________________</p>
                <p style="margin-right: 50px;">Firma y Sello</p>
            </div>
        </div>
        <div class="footer-info">
            <span>📱 Whatsapp: 973643675 | 📍 Edificio Empresarial Amauta Ofic. 901 | 🏥 Doctor Domicilio | @DoctorDomicilio</span>
        </div>
    </div>

</body>
</html>