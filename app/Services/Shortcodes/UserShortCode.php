<?php

namespace App\Services\Shortcodes;

use Illuminate\Support\Facades\Auth;

class UserShortcode
{
    public function register($shortcode, $content, $compiler, $name)
    {
        $user = Auth::user();
        list($key, $val) = explode('=', $shortcode->get('display', 'name'));
        $attr = [$key => str_replace('"', '', $val)];
        $display = $user->getAttribute($attr['display']);

        return $display;
    }
}