<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugSession
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        Log::info('Debug Session', [
            'session_id' => session()->getId(),
            'session_data' => session()->all(),
            'locale' => app()->getLocale(),
            'session_locale' => session('locale'),
            'cookies' => $request->cookies->all(),
            'headers' => $request->headers->all(),
        ]);
        
        return $response;
    }
}
