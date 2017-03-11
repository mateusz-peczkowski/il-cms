<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('Pulpit nawigacyjny');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cmsbackend/dashboard')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => $this->pageTitle
        ]);
    }
}
