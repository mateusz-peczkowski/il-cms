<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Visitor;
use App;
use Session;

class DashboardController extends BackendController
{
    public function __construct(UserRepositoryInterface $userscount)
    {
        parent::__construct();
        $this->pageTitle = __('Pulpit nawigacyjny');
        $this->range = Visitor::range(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $this->rangeYear = Visitor::range(Carbon::now()->year.'-01-01 00:00:00', Carbon::now()->year.'-12-31 23:59:59');
        $this->userscount = $userscount->allUsersCount();
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
            'pageTitle' => $this->pageTitle,
            'visitors' => $this->range,
            'visitorsYear' => $this->rangeYear,
            'userscount' => $this->userscount,
            'is_active_nav' => 'dashboard'
        ]);
    }

    /**
     * Change current locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function changelocale($slug)
    {
        App::setLocale($slug);
        Session::put('cms_locale', $slug);
        return redirect()->back();
    }
}
