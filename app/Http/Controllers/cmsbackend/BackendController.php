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

    protected function responseOK($message = null)
    {
        $message = $message ?: __('Zapisane');
        return $this->response('OK', $message);
    }

    protected function responseError()
    {
        return $this->response('Error', __('Error message'));
    }

    protected function response($status, $message)
    {
        $ret = array();
        $ret['status'] = $status;
        if (!is_null($message))
        {
            $ret['message'] = $message;
        }
        return \Response::json($ret);
    }
}
