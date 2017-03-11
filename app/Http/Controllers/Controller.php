<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Visitor;

class Controller extends BaseController
{
    public function __construct()
    {
        Visitor::log();
    }
}
