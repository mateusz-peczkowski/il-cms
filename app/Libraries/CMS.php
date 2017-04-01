<?php
namespace App\Libraries;

use Request;
use URL;

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

}