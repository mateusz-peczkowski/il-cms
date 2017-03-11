<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Visitor;

class DashboardController extends BackendController
{
    public function __construct(UserRepositoryInterface $userscount)
    {
        parent::__construct();
        $this->pageTitle = __('Pulpit nawigacyjny');
        $this->range = Visitor::range(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
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
            'userscount' => $this->userscount
        ]);
    }
}
