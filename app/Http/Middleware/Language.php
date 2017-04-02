<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use App;
use Session;
use CMS;


class Language
{

    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Session::has('cms_locale') && CMS::isLocale(Session::get('cms_locale'))) {
            App::setLocale(Session::get('cms_locale'));
        } else {
            App::setLocale(CMS::getDefaultLocale());
            Session::put('cms_locale', CMS::getDefaultLocale());
        }
        return $next($request);
    }

}
