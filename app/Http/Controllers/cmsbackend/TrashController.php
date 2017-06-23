<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RedirectRepositoryInterface;
use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\ModuleRepositoryInterface;
use App\Repositories\Contracts\NavigationRepositoryInterface;
use Auth;

class TrashController extends BackendController
{
    public function __construct(UserRepositoryInterface $user, RedirectRepositoryInterface $redirect, TranslationRepositoryInterface $translation, LanguageRepositoryInterface $language, FormRepositoryInterface $form, PageRepositoryInterface $page, ModuleRepositoryInterface $module, NavigationRepositoryInterface $navigation)
    {
        parent::__construct();
        $this->user = $user;
        $this->redirect = $redirect;
        $this->translation = $translation;
        $this->language = $language;
        $this->form = $form;
        $this->page = $page;
        $this->module = $module;
        $this->navigation = $navigation;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginatedUsersTrash();
        $redirects = $this->redirect->paginatedRedirectsTrash();
        $translations = $this->translation->paginatedTranslationsTrash();
        $languages = $this->language->paginatedLanguagesTrash();
        $forms = $this->form->paginatedFormsTrash();
        $pages = $this->page->paginatedPagesTrash();
        $modules = $this->module->paginatedModulesTrash();
        $navigations = $this->navigation->paginatedNavigationsTrash();
        $this->breadcrumbs->addCrumb(__('Usunięte elementy'), '/cmsbackend/trash');
        return view('cmsbackend.trash.index')->with([
            'users' => $users,
            'redirects' => $redirects,
            'translations' => $translations,
            'languages' => $languages,
            'forms' => $forms,
            'pages' => $pages,
            'modules' => $modules,
            'navigations' => $navigations,
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Usunięte elementy'),
            'is_active_nav' => 'trash'
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
    public function destroy($module, $id, $type = '')
    {
        $statusmsg = __('Element usunięty');

        if($type == 'destroy') {
            $this->$module->destroy($id);
        } else {
            $this->$module->update([
                'status' => 4,
                'who_updated' => Auth::id()
            ], $id);
        }

        return redirect()->route('trash')->with([
            'status-'.$module => $statusmsg,
            'status_type' => 'danger'
        ]);

    }
}
