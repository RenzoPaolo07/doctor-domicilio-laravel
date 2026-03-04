<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Pacientes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2cm; }
        h1 { color: #4a69bd; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #4a69bd; color: white; padding: 10px; text-align: left; }
        td { border: 1px solid #ddd; padding: 8px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <h1>Doctor Domicilio - Listado de Pacientes</h1>
    <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Tipo Sangre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->apellido }}</td>
                <td>{{ $p->telefono ?? 'N/E' }}</td>
                <td>{{ $p->email ?? 'N/E' }}</td>
                <td>{{ $p->tipo_sangre ?? 'N/E' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total de pacientes: {{ $pacientes->count() }}</p>
    </div>
</body>
</html>