<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
//        if ($lang = $request->session()->get('lang')) {
//            \App::setLocale($lang);
//        }
//        return $next($request);
        app()->setLocale($request->segment(1));
        return $next($request);
    }
}