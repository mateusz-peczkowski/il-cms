<?php

namespace App\Http\Controllers\cmsbackend;

class DocumentationController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application documentation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Dokumentacja'), '/cmsbackend/documentation');
        return view('cmsbackend.documentation.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Dokumentacja')
        ]);
    }

}
