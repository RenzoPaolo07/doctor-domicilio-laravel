<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Informado #{{ $consentimiento->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2cm;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4a69bd;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4a69bd;
            margin-bottom: 5px;
        }
        .paciente-info {
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .procedimiento {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 5px solid #4a69bd;
            border-radius: 5px;
            white-space: pre-line;
        }
        .firma-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .firma-box {
            text-align: center;
            width: 45%;
        }
        .firma-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 10px;
        }
        .firma-img {
            max-width: 200px;
            max-height: 80px;
            margin: 10px auto;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Domicilio</h1>
        <h3>Consentimiento Informado #{{ $consentimiento->id }}</h3>
    </div>

    <div class="paciente-info">
        <h3>Datos del Paciente</h3>
        <p><strong>Nombre:</strong> {{ $consentimiento->paciente->nombre_completo }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $consentimiento->paciente->fecha_nacimiento?->format('d/m/Y') }}</p>
        <p><strong>Edad:</strong> {{ $consentimiento->paciente->edad }} años</p>
        <p><strong>Fecha del Consentimiento:</strong> {{ $consentimiento->fecha->format('d/m/Y') }}</p>
    </div>

    <div class="procedimiento">
        <h3>Procedimiento / Tratamiento</h3>
        <p>{{ $consentimiento->procedimiento }}</p>
    </div>

    @if($consentimiento->testigos)
    <div style="margin: 20px 0;">
        <h3>Testigos</h3>
        <p>{{ $consentimiento->testigos }}</p>
    </div>
    @endif

    <div class="firma-section">
        <div class="firma-box">
            <p><strong>Firma del Paciente / Representante</strong></p>
            <img src="{{ $consentimiento->firma_digital }}" class="firma-img" alt="Firma">
            <div class="firma-line">
                Nombre: {{ $consentimiento->paciente->nombre_completo }}
            </div>
        </div>
        
        <div class="firma-box">
            <p><strong>Firma del Médico</strong></p>
            <div style="height: 60px;"></div>
            <div class="firma-line">
                Dr. {{ Auth::user()->nombre }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Documento generado por Doctor Domicilio - Sistema de Gestión Clínica</p>
    </div>
</body>
</html>