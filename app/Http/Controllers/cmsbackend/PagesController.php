<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\PageRepositoryInterface;
use Auth;
use Session;
use CMS;

class PagesController extends BackendController
{
    public function __construct(PageRepositoryInterface $pages)
    {
        parent::__construct();
        $this->pages = $pages;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');

        $pages = $this->pages->paginatedPages($this->checkLocale());
        return view('cmsbackend.pages.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Strony'),
            'pages' => $pages
        ]);
    }

    /**
     * Activate the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $statusmsg = __('Strona aktywowana');
        return $this->change_status($id, 1, $statusmsg, 'success');
    }

    /**
     * Deactivate the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $statusmsg = __('Strona zdezaktywowana');
        return $this->change_status($id, 2, $statusmsg, 'success');
    }

    /**
     * Delete the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $statusmsg = __('Strona usunięta');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->pages->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('pages')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($slug)
    {
        Session::put('cms_locale_page', $slug);
    }

    /**
     * Change component locale with redirect back.
     *
     * @return \Illuminate\Http\Response
     */
    public function changelocale($slug)
    {
        $this->locale($slug);
        return redirect()->back();
    }

    /**
     * Check component locale.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkLocale()
    {
        if(Session::has('cms_locale_page') && CMS::isLocale(Session::get('cms_locale_page'))) {
            return Session::get('cms_locale_page');
        }
        $this->locale(CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }

}
