<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('locale')) {
            session([
                'locale' => config('app.locale'),
            ]);
        }
        Lang::setLocale(session('locale'));

        return $next($request);
    }
}
