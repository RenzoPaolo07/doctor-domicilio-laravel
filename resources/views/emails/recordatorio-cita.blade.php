<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .cita-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Domicilio</h1>
        <p>Recordatorio de Cita Médica</p>
    </div>

    <div class="content">
        <h2>Hola, {{ $cita->paciente->nombre_completo }}</h2>
        
        <p>Te recordamos que tienes una cita médica programada:</p>

        <div class="cita-info">
            <p><strong>Fecha:</strong> {{ $cita->proxima_cita->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ $cita->proxima_cita->format('h:i A') }}</p>
            <p><strong>Motivo:</strong> {{ $cita->motivo_consulta ?? 'Consulta general' }}</p>
            <p><strong>Médico:</strong> Dr. {{ $cita->doctor->nombre ?? 'Asignado' }}</p>
        </div>

        <p>Por favor, llega 15 minutos antes de tu cita. Si no puedes asistir, por favor cancela con anticipación.</p>

        <a href="{{ route('calendario.index') }}" class="btn">Ver mi calendario</a>

        <p>¡Gracias por confiar en nosotros!</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Doctor Domicilio - Sistema de Gestión Clínica</p>
        <p>Este es un mensaje automático, por favor no responder.</p>
    </div>
</body>
</html>