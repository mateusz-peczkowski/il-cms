<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreNavigation;
use App\Http\Requests\UpdateNavigation;
use App\Repositories\Contracts\NavigationRepositoryInterface;
use Auth;
use Session;
use CMS;

class NavigationsController extends BackendController
{
    public function __construct(NavigationRepositoryInterface $navigations)
    {
        parent::__construct();
        $this->navigations = $navigations;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Nawigacje'), '/cmsbackend/navigations');

        $navigations = $this->navigations->paginatedNavigations();
        return view('cmsbackend.navigations.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Nawigacje'),
            'navigations' => $navigations,
            'is_active_nav' => 'settings/navigations'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNavigation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNavigation $request)
    {
        $obj = $request->only('title', 'tag');

        $last = $this->navigations->all()->count() ? $this->navigations->orderBy('order', 'desc')->first() : false;
        $order = $last ? $last->order+1 : '1';
        $obj['slug'] = $this->constructSlug(0, $obj['title']);
        $obj['order'] = $order;
        $obj['who_updated'] = Auth::id();
        $obj['status'] = 1;
        $obj['tag'] = $this->constructTag(0, $obj['tag']);
        $this->navigations->create($obj);
        return redirect()->route('index-navigations')->with([
            'status' => __('Nawigacja została stworzona'),
            'status_type' => 'success'
        ]);

    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $navigation = $this->navigations->find($id);
        $this->breadcrumbs->addCrumb(__('Nawigacje'), '/cmsbackend/settings/navigations');
        $this->breadcrumbs->addCrumb(__('Edytuj nawigacje'), '/cmsbackend/settings/navigations/'.$id.'/edit');
        return view('cmsbackend.navigations.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj nawigacje'),
            'navigation' => $navigation,
            'is_active_nav' => 'settings/navigations'
        ]);
    }

    /**
     * update created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdateNavigation  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateNavigation  $request)
    {
        $obj = $request->only('title', 'tag');
        if($obj['title'] != $this->navigations->find($id)->title) {
            $obj['slug'] = $this->constructSlug(0, $obj['title']);
        }
        if($obj['tag'] != $this->navigations->find($id)->tag) {
            $obj['tag'] =  $this->constructTag(0, $obj['tag']);
        }
        $obj['who_updated'] = Auth::id();
        $this->navigations->update($obj, $id);
        return redirect()->route('index-navigations')->with([
            'status' => __('Nawigacja została zaaktualizowana'),
            'status_type' => 'success'
        ]);

    }

    private function constructSlug($num, $name) {
        if($num) {
            $slug = str_slug($name).'-'.$num;
        } else {
            $slug = str_slug($name);
        }
        if($this->navigations->findBy('slug', $slug)) {
            $num++;
            return $this->constructSlug($num, $name);
        }
        return $slug;
    }

    private function constructTag($num, $name) {
        if($num) {
            $tag = str_slug($name).'-'.$num;
        } else {
            $tag = str_slug($name);
        }
        if($this->navigations->findBy('tag', $tag)) {
            $num++;
            return $this->constructTag($num, $name);
        }
        return $tag;
    }

    /**
     * Activate the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $statusmsg = __('Nawigacja aktywowana');
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
        $statusmsg = __('Nawigacja zdezaktywowana');
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
        $statusmsg = __('Nawigacja usunięta');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->navigations->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('index-navigations')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

}
