<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Http\Request;
use App\Repositories\Contracts\SeoRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use Auth;
use Session;
use CMS;

class SeoController extends BackendController
{
    public function __construct(SeoRepositoryInterface $seo, PageRepositoryInterface $pages)
    {
        parent::__construct();
        $this->seo = $seo;
        $this->pages = $pages;
    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($model, $model_id)
    {
        $seo = $this->seo->getByModel($model, $model_id);
        $model_obj = $this->$model->find($model_id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj meta dane'), '/cmsbackend/pages/'.$model_id.'/seo');
        return view('cmsbackend.seo.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj meta dane'),
            'seo' => $seo,
            'model' => $model_obj,
            'model_name' => $model,
            'is_active_nav' => $model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $model
     * @param int $model_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($model, $model_id, Request $request)
    {
        $obj = $request->only('meta_title', 'meta_description', 'meta_keys', 'page_head', 'page_footer');
        $obj['who_updated'] = Auth::id();
        $obj['model'] = $model;
        $obj['model_id'] = $model_id;
        $this->seo->create($obj);
        return redirect()->route('seo', ['model' => $model, 'model_id' => $model_id])->with([
            'status' => __('Meta dane zostały zaaktualizowane'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Update resource in storage.
     *
     * @param string $model
     * @param int $model_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($model, $model_id, Request $request)
    {
        $obj = $request->only('meta_title', 'meta_description', 'meta_keys', 'page_head', 'page_footer');
        $obj['who_updated'] = Auth::id();
        $obj['model'] = $model;
        $obj['model_id'] = $model_id;
        $this->seo->update($obj, $request->get('seo_id'));
        return redirect()->route('seo', ['model' => $model, 'model_id' => $model_id])->with([
            'status' => __('Meta dane zostały zaaktualizowane'),
            'status_type' => 'success'
        ]);
    }
}
