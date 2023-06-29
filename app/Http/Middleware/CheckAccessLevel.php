<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $level
     * @return mixed
     */
    public function handle($request, Closure $next, $level)
    {
        $user = $request->user();
    
        switch ($user->nivel) {
            case 1:
                return $next($request);
            case 2:
                if (in_array($level, ['editar', 'deletar', 'listar'])) {
                    return $next($request);
                }
                break;
            case 3:
                if ($level == 'listar') {
                    return $next($request);
                }
                break;
        }
        
        return response()->json([
            'error' => 'Acesso não autorizado'
        ], 403);
    }
    
}
