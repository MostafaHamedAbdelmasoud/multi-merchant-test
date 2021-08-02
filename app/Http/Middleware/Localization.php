<?php

namespace App\Http\Middleware;

use Closure;

class Localization
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
        $lang = ['ar', 'en'];
        // Check header request and determine localization
        if ($request->hasHeader('X-localization')) {
            $local = (in_array($request->header('X-localization'), $lang)) ?
                $request->header('X-localization') : 'en';
        } else {
            $local = 'en';
        }
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }
}
