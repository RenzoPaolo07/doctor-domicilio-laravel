<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Boleta {{ $boleta->numero_boleta }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 1.5cm;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 4px solid #1a365d;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1a365d;
            margin-bottom: 5px;
            font-size: 28px;
        }
        .header h3 {
            color: #666;
            font-weight: normal;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .paciente-info, .boleta-info {
            width: 48%;
        }
        .paciente-info h3, .boleta-info h3 {
            color: #1a365d;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-row strong {
            display: inline-block;
            width: 100px;
            color: #2c3e50;
        }
        .concepto-box {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 5px solid #1a365d;
            border-radius: 5px;
        }
        .concepto-box h3 {
            color: #1a365d;
            margin-bottom: 10px;
        }
        .monto-box {
            text-align: right;
            margin: 30px 0;
            padding: 20px;
            background: #d4edda;
            border-radius: 10px;
        }
        .monto-box .label {
            font-size: 18px;
            color: #155724;
        }
        .monto-box .valor {
            font-size: 36px;
            font-weight: bold;
            color: #155724;
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
        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .badge-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Doctor Domicilio</h1>
        <h3>Boleta de Venta Electrónica</h3>
        <h2 style="color: #1a365d;">{{ $boleta->numero_boleta }}</h2>
    </div>

    <div class="info-box">
        <div class="paciente-info">
            <h3>Datos del Paciente</h3>
            <div class="info-row"><strong>Nombre:</strong> {{ $boleta->paciente->nombre_completo }}</div>
            <div class="info-row"><strong>Email:</strong> {{ $boleta->paciente->email ?? 'N/E' }}</div>
            <div class="info-row"><strong>Teléfono:</strong> {{ $boleta->paciente->telefono ?? 'N/E' }}</div>
        </div>
        
        <div class="boleta-info">
            <h3>Datos de la Boleta</h3>
            <div class="info-row"><strong>Fecha:</strong> {{ $boleta->fecha->format('d/m/Y') }}</div>
            <div class="info-row"><strong>Método Pago:</strong> {{ ucfirst($boleta->metodo_pago ?? 'N/E') }}</div>
            <div class="info-row">
                <strong>Estado:</strong> 
                @if($boleta->estado == 'pagado')
                    <span class="badge badge-success">Pagado</span>
                @elseif($boleta->estado == 'pendiente')
                    <span class="badge badge-warning">Pendiente</span>
                @else
                    <span>Anulado</span>
                @endif
            </div>
        </div>
    </div>

    <div class="concepto-box">
        <h3>Concepto</h3>
        <p>{{ $boleta->concepto }}</p>
    </div>

    <div class="monto-box">
        <div class="label">Total a Pagar</div>
        <div class="valor">S/ {{ number_format($boleta->monto, 2) }}</div>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #666;">
        <p>Esta boleta es un comprobante válido de pago</p>
        <p>¡Gracias por confiar en Doctor Domicilio!</p>
    </div>

    <div class="footer">
        <p>Documento generado por Doctor Domicilio - Sistema de Gestión Clínica</p>
    </div>
</body>
</html>