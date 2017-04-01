<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Creitive\Breadcrumbs\Breadcrumbs as breadcrumb;

class BackendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $breadcrumbs;

    public function __construct()
    {
        $this->middleware('language');
        $this->breadcrumbs = new breadcrumb;
        $this->breadcrumbs->setCssClasses('breadcrumb');
        $this->breadcrumbs->setDivider('');
        $this->breadcrumbs->addCrumb('<i class="fa fa-home"></i>', '/cmsbackend');
        $this->breadcrumbs->addCrumb(__('Pulpit nawigacyjny'), '/cmsbackend');
    }
}
