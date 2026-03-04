<?php

namespace App\Exports;

use App\Models\Paciente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PacientesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Paciente::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellido',
            'Fecha Nacimiento',
            'Género',
            'Teléfono',
            'Email',
            'Dirección',
            'Alergias',
            'Tipo Sangre',
            'Contacto Emergencia',
            'Tel. Emergencia',
            'Fecha Registro'
        ];
    }

    public function map($paciente): array
    {
        return [
            $paciente->id,
            $paciente->nombre,
            $paciente->apellido,
            $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : 'N/E',
            $paciente->genero == 'M' ? 'Masculino' : ($paciente->genero == 'F' ? 'Femenino' : 'N/E'),
            $paciente->telefono ?? 'N/E',
            $paciente->email ?? 'N/E',
            $paciente->direccion ?? 'N/E',
            $paciente->alergias ?? 'Ninguna',
            $paciente->tipo_sangre ?? 'N/E',
            $paciente->contacto_emergencia ?? 'N/E',
            $paciente->telefono_emergencia ?? 'N/E',
            $paciente->created_at->format('d/m/Y H:i'),
        ];
    }
}