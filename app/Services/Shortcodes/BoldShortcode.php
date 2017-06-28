<?php

namespace App\Services\Shortcodes;

class BoldShortcode
{
    public function register($shortcode, $content, $compiler, $name)
    {
        return '<strong ' . $shortcode->get('class', 'default') . '>' . $content . '</strong>';
    }
}