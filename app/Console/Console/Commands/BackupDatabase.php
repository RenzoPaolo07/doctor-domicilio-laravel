<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Realiza backup de la base de datos';

    public function handle()
    {
        $this->info('Iniciando backup de la base de datos...');

        // Obtener configuración de la base de datos
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        
        // Nombre del archivo de backup
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);
        
        // Crear directorio si no existe
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Comando mysqldump
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Backup creado exitosamente: {$filename}");
            
            // Eliminar backups antiguos (mantener solo los últimos 7 días)
            $this->limpiarBackupsAntiguos();
        } else {
            $this->error('Error al crear el backup');
        }

        return Command::SUCCESS;
    }

    private function limpiarBackupsAntiguos()
    {
        $backups = glob(storage_path('app/backups/*.sql'));
        $fechaLimite = now()->subDays(7)->timestamp;

        foreach ($backups as $backup) {
            if (filemtime($backup) < $fechaLimite) {
                unlink($backup);
                $this->info("Backup antiguo eliminado: " . basename($backup));
            }
        }
    }
}