<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\HistoriaClinica;
use App\Models\Boleta;
use App\Exports\PacientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function pacientesExcel()
    {
        return Excel::download(new PacientesExport, 'pacientes.xlsx');
    }

    public function pacientesPdf()
    {
        $pacientes = Paciente::all();
        $pdf = PDF::loadView('export.pacientes-pdf', compact('pacientes'));
        return $pdf->download('pacientes.pdf');
    }

    public function citasExcel()
    {
        $citas = HistoriaClinica::with('paciente')
            ->whereNotNull('proxima_cita')
            ->orderBy('proxima_cita')
            ->get();

        return Excel::download(new class($citas) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $citas;

            public function __construct($citas)
            {
                $this->citas = $citas;
            }

            public function collection()
            {
                return $this->citas->map(function($cita) {
                    return [
                        'Paciente' => $cita->paciente->nombre_completo,
                        'Fecha Cita' => $cita->proxima_cita->format('d/m/Y'),
                        'Motivo' => $cita->motivo_consulta ?? 'No especificado',
                        'Teléfono' => $cita->paciente->telefono ?? 'N/E',
                    ];
                });
            }

            public function headings(): array
            {
                return ['Paciente', 'Fecha Cita', 'Motivo', 'Teléfono'];
            }
        }, 'citas.xlsx');
    }

    public function boletasExcel()
    {
        $boletas = Boleta::with('paciente')->orderBy('created_at', 'desc')->get();

        return Excel::download(new class($boletas) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $boletas;

            public function __construct($boletas)
            {
                $this->boletas = $boletas;
            }

            public function collection()
            {
                return $this->boletas->map(function($boleta) {
                    return [
                        'N° Boleta' => $boleta->numero_boleta,
                        'Paciente' => $boleta->paciente->nombre_completo,
                        'Fecha' => $boleta->fecha->format('d/m/Y'),
                        'Concepto' => $boleta->concepto,
                        'Monto' => $boleta->monto,
                        'Estado' => ucfirst($boleta->estado),
                        'Método Pago' => ucfirst($boleta->metodo_pago ?? 'N/E'),
                    ];
                });
            }

            public function headings(): array
            {
                return ['N° Boleta', 'Paciente', 'Fecha', 'Concepto', 'Monto', 'Estado', 'Método Pago'];
            }
        }, 'boletas.xlsx');
    }
}