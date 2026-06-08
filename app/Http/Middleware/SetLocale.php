<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // First check query string (e.g. ?locale=hi)
        if ($request->has('locale')) {
            $locale = $request->get('locale');
            if (in_array($locale, ['en', 'hi', 'pa'])) {
                session()->put('locale', $locale);
            }
        }

        // Apply locale from session (default to config value or 'en')
        $locale = session()->get('locale', config('app.locale', 'en'));
        App::setLocale($locale);

        return $next($request);
    }
}
