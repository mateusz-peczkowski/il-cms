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
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $language->isLocale($locale);
    }

    public static function getLocale()
    {
        return Session::get('cms_locale');
    }

    public static function getDefaultLocale()
    {
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        $locale = $language->getDefaultLocale();
        return $locale ? $locale[0]->slug : Config::get('app.fallback_locale');
    }

    public static function getMoreDefaultLocales()
    {
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $language->getMoreDefaultLocales();
    }

    public static function getMoreLocales()
    {
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $language->getMoreLocales();
    }

    public static function getLocalesExcept($locale = '')
    {
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $language->getLocalesExcept($locale);
    }

    public static function isMoreLocales()
    {
        $language = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $language->isMoreLocales();
    }

    public static function trans($key)
    {
        $translation = resolve('App\Repositories\Contracts\TranslationRepositoryInterface');
        $term = $translation->findByKey($key, CMS::getLocale());

        if (!$term) {
            $defaultTerm = $translation->findByKey($key, CMS::getDefaultLocale());
            if ($defaultTerm) {
                echo $defaultTerm->value;
                return;
            } else {
                return;
            }
        } else {
            echo $term->value;
            return;
        }
    }
}