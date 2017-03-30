<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\UserRepositoryInterface;

class TrashController extends BackendController
{
    public function __construct(UserRepositoryInterface $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Show the application trash.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginatedUsersTrash();
        $this->breadcrumbs->addCrumb(__('Usunięte elementy'), '/cmsbackend/trash');
        return view('cmsbackend.trash.index')->with([
            'users' => $users,
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Usunięte elementy')
        ]);
    }

    /**
     * @param  string  $module
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function revoke($module, $id)
    {
        $statusmsg = __('Element przywrócony');

        $this->$module->update([
            'status' => 2
        ], $id);
        return redirect()->route('trash')->with([
            'status-'.$module => $statusmsg,
            'status_type' => 'success'
        ]);

    }

    /**
     * @param  string  $module
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($module, $id)
    {
        $statusmsg = __('Element usunięty');

        $this->$module->destroy($id);

        return redirect()->route('trash')->with([
            'status-'.$module => $statusmsg,
            'status_type' => 'danger'
        ]);

    }
}
