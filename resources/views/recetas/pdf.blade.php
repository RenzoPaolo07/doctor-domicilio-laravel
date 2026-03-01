<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receta Médica #{{ $receta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2cm;
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
        .doctor-info {
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .paciente-info {
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-row strong {
            display: inline-block;
            width: 120px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #4a69bd;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .diagnostico {
            margin: 20px 0;
            padding: 15px;
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            border-radius: 5px;
        }
        .indicaciones {
            margin: 20px 0;
            padding: 15px;
            background: #d4edda;
            border-left: 5px solid #28a745;
            border-radius: 5px;
        }
        .firma {
            margin-top: 50px;
            text-align: right;
        }
        .firma-line {
            width: 250px;
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 10px;
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
        <h3>Receta Médica #{{ $receta->id }}</h3>
    </div>

    <div class="doctor-info">
        <h3><i class="fas fa-user-md"></i> Datos del Médico</h3>
        <div class="info-row"><strong>Médico:</strong> Dr. {{ $receta->doctor->nombre }}</div>
        <div class="info-row"><strong>Email:</strong> {{ $receta->doctor->email }}</div>
    </div>

    <div class="paciente-info">
        <h3><i class="fas fa-user"></i> Datos del Paciente</h3>
        <div class="info-row"><strong>Paciente:</strong> {{ $receta->paciente->nombre_completo }}</div>
        <div class="info-row"><strong>Edad:</strong> {{ $receta->paciente->edad }} años</div>
        <div class="info-row"><strong>Fecha Emisión:</strong> {{ $receta->fecha_emision->format('d/m/Y') }}</div>
    </div>

    <div class="diagnostico">
        <h3>Diagnóstico</h3>
        <p>{{ $receta->diagnostico ?? 'No especificado' }}</p>
    </div>

    <h3>Medicamentos Recetados</h3>
    <table>
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

    @if($receta->indicaciones)
    <div class="indicaciones">
        <h3>Indicaciones Adicionales</h3>
        <p>{{ $receta->indicaciones }}</p>
    </div>
    @endif

    <div class="firma">
        <div class="firma-line">
            Firma del Médico
        </div>
        <p>Dr. {{ $receta->doctor->nombre }}</p>
    </div>

    <div class="footer">
        <p>Documento generado por Doctor Domicilio - Sistema de Gestión Clínica</p>
    </div>
</body>
</html>