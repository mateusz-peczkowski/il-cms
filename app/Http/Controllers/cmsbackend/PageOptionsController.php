<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StorePageOption;
use App\Http\Requests\UpdatePageOption;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\PageOptionRepositoryInterface;
use Auth;
use Session;
use CMS;

class PageOptionsController extends BackendController
{
    public function __construct(PageRepositoryInterface $pages, PageOptionRepositoryInterface $page_options)
    {
        parent::__construct();
        $this->pages = $pages;
        $this->page_options = $page_options;
    }

    /**
     * Show the application resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $page = $this->pages->find($id);
        $options = count($this->page_options->findBy('page_id', $id)) ? $this->page_options->findBy('page_id', $id)->paginate() : collect([]);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Opcje'), '/cmsbackend/pages/'.$id.'/options');
        return view('cmsbackend.page_options.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Opcje'),
            'page' => $page,
            'options' => $options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\StorePageOption  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StorePageOption $request)
    {
        $obj = $request->only('key', 'type', 'values');
        $obj['who_updated'] = Auth::id();
        $obj['page_id'] = $id;

        $obj['slug'] = $this->constructSlug(0, $obj['key']);

        $this->page_options->create($obj);

        return redirect()->route('pages.options', $id)->with([
            'status' => __('Opcja dodana'),
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
        $option = $this->page_options->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj opcje'), '/cmsbackend/pages/options/'.$id.'/edit');
        return view('cmsbackend.page_options.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj opcje'),
            'option' => $option
        ]);
    }

    /**
     * Update created resource.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdatePage  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdatePageOption $request)
    {
        $obj = $request->only('key', 'type', 'values');
        $obj['who_updated'] = Auth::id();
        $this->page_options->update($obj, $id);
        $page_id = $this->page_options->find($id)->page_id;

        return redirect()->route('pages.options', $page_id)->with([
            'status' => __('Opcja zaaktualizowana'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit value of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function value($id)
    {
        $option = $this->page_options->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj opcje'), '/cmsbackend/pages/options/'.$id.'/edit');
        $this->breadcrumbs->addCrumb(__('Edytuj wartość'), '/cmsbackend/pages/options/'.$id);
        return view('cmsbackend.page_options.value')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj wartość'),
            'option' => $option
        ]);
    }

    /**
     * Update value of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_value($id, Request $request)
    {
        $obj = $request->only('value');
        if(is_array($obj['value'])) {
            $obj['value'] = implode(',', $obj['value']);
        }
        $obj['who_updated'] = Auth::id();
        $this->page_options->update($obj, $id);
        $page_id = $this->page_options->find($id)->page_id;

        return redirect()->route('pages.options', $page_id)->with([
            'status' => __('Wartość opcji zaaktualizowana'),
            'status_type' => 'success'
        ]);
    }



    /**
     * @param  string  $module
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page_id = $this->page_options->find($id)->page_id;
        $this->page_options->destroy($id);

        return redirect()->route('pages.options', $page_id)->with([
            'status' => __('Opcja usunięta'),
            'status_type' => 'danger'
        ]);

    }


    private function constructSlug($num, $name) {
        if($num) {
            $slug = str_slug($name).'-'.$num;
        } else {
            $slug = str_slug($name);
        }
        if($this->page_options->findBy('slug', $slug)) {
            $num++;
            return $this->constructSlug($num, $name);
        }
        return $slug;
    }

}
