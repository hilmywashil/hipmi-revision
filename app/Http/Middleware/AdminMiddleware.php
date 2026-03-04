<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        
        if (!Auth::guard('admin')->check()) {
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                    'redirect' => route('admin.login')
                ], 401);
            }
            
         
            return redirect()->route('admin.login')
                ->with('warning', 'Sesi Anda telah berakhir. Silakan login kembali.')
                ->withInput(); 
        }

        return $next($request);
    }
}