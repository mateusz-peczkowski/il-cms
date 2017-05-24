<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StorePage;
use App\Http\Requests\UpdatePage;
use Illuminate\Http\Request;
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePage  $request)
    {
        $obj = $request->only('name', 'description', 'thumbnail');
        if($obj['thumbnail']) {
            $newname = str_slug(pathinfo($obj['thumbnail']->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$obj['thumbnail']->getClientOriginalExtension();
            $obj['thumbnail']->move(public_path('source/pages'), $newname);
            $obj['thumbnail'] = '/source/pages/'.$newname;
        }
        $obj['url'] = '/'.str_slug($obj['name']);
        if($this->pages->checkPageExistByURL($obj['url'], $this->checkLocale())) {
            $obj['url'] = $obj['url'].'-'.time();
        }
        $last = $this->pages->findBy('locale', $this->checkLocale()) ? $this->pages->findBy('locale', $this->checkLocale())->orderBy('order', 'desc')->first() : false;
        $order = $last ? $last->order+1 : '1';
        $obj['order'] = $order;
        $obj['locale'] = $this->checkLocale();
        $obj['who_updated'] = Auth::id();
        $obj['status'] = 1;
        $page = $this->pages->create($obj);
        return redirect()->route('pages.edit', $page->id);

    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = $this->pages->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj stronę'), '/cmsbackend/pages/'.$id.'/edit');
        return view('cmsbackend.pages.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj stronę'),
            'page' => $page
        ]);
    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdatePage  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdatePage $request)
    {
        $obj = $request->only('name', 'description', 'thumbnail', 'url');
        if($this->pages->find($id)->url == $obj['url'] || !$this->pages->checkPageExistByURL($obj['url'], $this->checkLocale())) {
            if($obj['thumbnail']) {
                $newname = str_slug(pathinfo($obj['thumbnail']->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$obj['thumbnail']->getClientOriginalExtension();
                $obj['thumbnail']->move(public_path('source/pages'), $newname);
                $obj['thumbnail'] = '/source/pages/'.$newname;
            } else {
                unset($obj['thumbnail']);
            }
            $obj['who_updated'] = Auth::id();
            $this->pages->update($obj, $id);
            return redirect()->route('pages')->with([
                'status' => __('Strona została zaaktualizowana'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('pages.edit', $id)->with([
            'status' => __('Strona o podanych danych już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
    }

    /**
     * Gallery of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gallery($id)
    {
        $page = $this->pages->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Zdjęcia'), '/cmsbackend/pages/'.$id.'/gallery');
        return view('cmsbackend.pages.gallery')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Zdjęcia'),
            'page' => $page
        ]);
    }

    /**
     * Sections of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sections($id)
    {
        $page = $this->pages->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Sekcje'), '/cmsbackend/pages/'.$id.'/sections');
        return view('cmsbackend.pages.sections')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Sekcje'),
            'page' => $page
        ]);
    }

    /**
     * Advanced of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function advanced($id)
    {
        $page = $this->pages->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Zaawansowane'), '/cmsbackend/pages/'.$id.'/advanced');
        return view('cmsbackend.pages.advanced')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Zaawansowane'),
            'page' => $page
        ]);
    }

    /**
     * Advanced of created resource.
     *
     * @param  int  $id
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update_advanced($id, Request $request)
    {
        $obj = $request->only('tag', 'controller', 'view');
        if($this->pages->find($id)->tag == $obj['tag'] || !$this->pages->checkPageExist($obj['tag'], $this->checkLocale())) {
            $obj['who_updated'] = Auth::id();
            $this->pages->update($obj, $id);
            return redirect()->route('pages.advanced', $id)->with([
                'status' => __('Dane zostały zaaktualizowane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('pages.advanced', $id)->with([
            'status' => __('Strona o podanych danych już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
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
