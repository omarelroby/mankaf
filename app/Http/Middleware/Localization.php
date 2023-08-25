<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader("locale")) {
            /**
             * If Accept-Language header found then set it to the default locale
             */
            App::setLocale($request->header("locale"));
        }
        return $next($request);
    }
}
