<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        return view('cmsbackend/users/show')->with([
            'user' => $user,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}
