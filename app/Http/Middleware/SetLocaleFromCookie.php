<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class SetLocaleFromCookie 
{
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);

        if (in_array($locale, config('app.available_locales'))) {
            app()->setLocale($locale);
        } else {
            $cookieLocale = Cookie::get('locale', config('app.fallback_locale'));
            app()->setLocale($cookieLocale);
        }

        return $next($request);
    }
}
