<?php

namespace App\Http\Middleware;

use App\Models\Auditoria;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditoriaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Solo auditar métodos de escritura
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->registrarAuditoria($request);
        }

        return $response;
    }

    private function registrarAuditoria(Request $request)
    {
        $datos = [
            'usuario_id' => Auth::id(),
            'accion' => $request->method(),
            'modelo' => $this->getModelo($request->path()),
            'modelo_id' => $request->route('id') ?? $request->route('paciente') ?? null,
            'datos_nuevos' => $request->except(['_token', '_method']),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        Auditoria::create($datos);
    }

    private function getModelo($path)
    {
        $partes = explode('/', $path);
        return $partes[0] ?? 'desconocido';
    }
}