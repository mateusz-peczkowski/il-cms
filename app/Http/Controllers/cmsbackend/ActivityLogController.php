<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Dziennik aktywności'), '/cmsbackend/activity');
        $activity = Activity::inLog('default')->orderBy('id', 'desc')->paginate(30, ['*'], 'activity');
        $userActivity = Activity::inLog('user')->orderBy('id', 'desc')->paginate(30, ['*'], 'activityuser');

        return view('cmsbackend.activity.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Dziennik aktywności'),
            'activity' => $activity,
            'userActivity' => $userActivity,
            'is_active_nav' => 'activity'
        ]);
    }
}
