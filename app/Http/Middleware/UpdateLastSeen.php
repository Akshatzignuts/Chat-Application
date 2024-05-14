<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check()) {
            $user = Auth::user();
            $lastSeen =    $user->update(['last_seen' => now()]);
            // Update the last_seen column with the current timestamp
             Carbon::parse($lastSeen)->diffForHumans();
        }
        return $next($request);
    }
}