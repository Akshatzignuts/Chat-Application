<?php

namespace App\Http\Middleware;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

    if ($user) {
        $user->userActivity()->updateOrCreate([], [
            'last_activity' => now()
        ]);
    }
        return $next($request);
    }
}