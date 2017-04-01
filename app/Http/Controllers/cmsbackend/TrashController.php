<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RedirectRepositoryInterface;
use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Auth;

class TrashController extends BackendController
{
    public function __construct(UserRepositoryInterface $user, RedirectRepositoryInterface $redirect, TranslationRepositoryInterface $translation, LanguageRepositoryInterface $language)
    {
        parent::__construct();
        $this->user = $user;
        $this->redirect = $redirect;
        $this->translation = $translation;
        $this->language = $language;
    }

    /**
     * Show the application trash.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginatedUsersTrash();
        $redirects = $this->redirect->paginatedRedirectsTrash();
        $translations = $this->translation->paginatedTranslationsTrash();
        $languages = $this->language->paginatedLanguagesTrash();
        $this->breadcrumbs->addCrumb(__('Usunięte elementy'), '/cmsbackend/trash');
        return view('cmsbackend.trash.index')->with([
            'users' => $users,
            'redirects' => $redirects,
            'translations' => $translations,
            'languages' => $languages,
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
            'status' => 2,
            'who_updated' => Auth::id()
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
