<?php

namespace App\Http\Controllers\cmsbackend;

class FilesManagerController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        return view('cmsbackend.filesmanager.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Menedżer plików'),
            'filemanager' => \Config::get('app.filemanager.path').'type=2&amp;field_id=GalleryMedia__path'
        ]);
    }

}
