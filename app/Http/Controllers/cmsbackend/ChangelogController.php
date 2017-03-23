<?php

namespace App\Http\Controllers\cmsbackend;

class ChangelogController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admins');
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Dziennik zmian'), '/cmsbackend/changelog');
        return view('cmsbackend.changelog.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Dziennik zmian')
        ]);
    }

}
