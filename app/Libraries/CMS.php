<?php
namespace App\Libraries;

use Request;
use URL;
use Config;
use Session;

class CMS
{

    public static function render($controller, $parameters = array(), $config = array())
    {
        if (!$controller)
        {
            $controller = 'GenericController@index';
        }
        preg_match('|(.*)@(.*)|', $controller, $matches);
        $controller_name = $matches[1];
        $controller = new $controller_name($config);
        if (is_null($parameters)) $parameters = array();
        return $controller->callAction($matches[2], $parameters);
    }

    public static function urlAddress()
    {
        $url = str_replace(Request::root(), '', URL::full());
        return $url;
    }

    public static function isLocale($locale = '')
    {
        return 'App\Language'::where('status', '1')->where('slug', '=', $locale)->count();;
    }

    public static function getLocale()
    {
        return Session::get('cms_locale');
    }

    public static function getDefaultLocale()
    {
        $locale = 'App\Language'::where('status', '1')->where('is_default', '=', '1')->get();
        return $locale ? $locale[0]->slug : Config::get('app.fallback_locale');
    }

    public static function getMoreDefaultLocales()
    {
        return 'App\Language'::where('status', '1')->where('is_default', '!=', '1')->get();
    }

    public static function getMoreLocales()
    {
        return 'App\Language'::where('status', '1')->where('slug', '!=', Session::get('cms_locale'))->get();
    }

    public static function getLocalesExcept($locale = '')
    {
        return 'App\Language'::where('status', '1')->where('slug', '!=', $locale)->get();
    }

    public static function isMoreLocales()
    {
        return 'App\Language'::where('is_default', '!=', '1')->where('status', '1')->count();
    }

}