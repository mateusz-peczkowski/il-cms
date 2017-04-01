<?php

namespace App\Http\Controllers\cmsbackend;

class ChangelogController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('developers');
    }

    /**
     * Show the application changelog.
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
