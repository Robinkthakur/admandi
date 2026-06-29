<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Throttle updating DB to once every 5 minutes
            if ($user->last_active_at === null || $user->last_active_at->diffInMinutes(now()) >= 5) {
                $user->update([
                    'last_active_at' => now(),
                    'inactive_notified_at' => null, // Reset since user is active now
                ]);
            }
        }

        return $next($request);
    }
}
