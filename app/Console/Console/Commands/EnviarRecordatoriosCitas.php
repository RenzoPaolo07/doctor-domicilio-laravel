<?php

namespace App\Console\Commands;

use App\Models\HistoriaClinica;
use App\Models\Configuracion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatoriosCitas extends Command
{
    protected $signature = 'citas:recordatorios';
    protected $description = 'Envía recordatorios de citas por email';

    public function handle()
    {
        $manana = now()->addDay()->toDateString();
        
        $citasManana = HistoriaClinica::with('paciente')
            ->whereDate('proxima_cita', $manana)
            ->get();

        $this->info("Enviando recordatorios para {$citasManana->count()} citas de mañana...");

        foreach ($citasManana as $cita) {
            try {
                Mail::send('emails.recordatorio-cita', ['cita' => $cita], function ($message) use ($cita) {
                    $message->to($cita->paciente->email, $cita->paciente->nombre_completo)
                            ->subject('Recordatorio de Cita Médica - Doctor Domicilio');
                });
                
                $this->info("Recordatorio enviado a: {$cita->paciente->email}");
            } catch (\Exception $e) {
                $this->error("Error al enviar a {$cita->paciente->email}: {$e->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }
}