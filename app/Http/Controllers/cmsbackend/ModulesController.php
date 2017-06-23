<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreModule;
use App\Http\Requests\UpdateModule;
use App\Repositories\Contracts\ModuleRepositoryInterface;
use Auth;
use Session;

class ModulesController extends BackendController
{
    public function __construct(ModuleRepositoryInterface $modules)
    {
        parent::__construct();
        $this->modules = $modules;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Moduły'), '/cmsbackend/settings/modules');

        $modules = $this->modules->paginatedModules();
        return view('cmsbackend.modules.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Moduły'),
            'modules' => $modules,
            'is_active_nav' => 'settings/modules'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModule  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModule  $request)
    {
        $obj = $request->only('title', 'has_details');
        $last = $this->modules->all()->count() ? $this->modules->orderBy('order', 'desc')->first() : false;
        $order = $last ? $last->order+1 : '1';
        $obj['slug'] = $this->constructSlug(0, $obj['title']);
        $obj['order'] = $order;
        $obj['who_updated'] = Auth::id();
        $obj['status'] = 1;
        $obj['has_details'] = $obj['has_details'] ? 1 : 0;
        $module = $this->modules->create($obj);
        return redirect()->route('edit-modules', $module->id)->with([
            'status' => __('Moduł został stworzony'),
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
        $module = $this->modules->find($id);
        $this->breadcrumbs->addCrumb(__('Moduły'), '/cmsbackend/settings/modules');
        $this->breadcrumbs->addCrumb(__('Edytuj moduł'), '/cmsbackend/settings/modules/'.$id.'/edit');
        return view('cmsbackend.modules.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj moduł'),
            'module' => $module,
            'is_active_nav' => 'settings/modules'
        ]);
    }

    /**
     * update created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdateModule  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateModule  $request)
    {
        $obj = $request->only('title', 'structure', 'has_details', 'order_records', 'order_records_type');
        if($obj['title'] != $this->modules->find($id)->title) {
            $obj['slug'] = $this->constructSlug(0, $obj['title']);
        }
        $obj['who_updated'] = Auth::id();
        $obj['has_details'] = $obj['has_details'] ? 1 : 0;
        $this->modules->update($obj, $id);
        return redirect()->route('index-modules')->with([
            'status' => __('Moduł został zaaktualizowany'),
            'status_type' => 'success'
        ]);

        }


        private function constructSlug($num, $name) {
            if($num) {
                $slug = str_slug($name).'-'.$num;
            } else {
                $slug = str_slug($name);
            }
            if($this->modules->findBy('slug', $slug)) {
                $num++;
                return $this->constructSlug($num, $name);
            }
            return $slug;
        }

    /**
     * Activate the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $statusmsg = __('Moduł aktywowany');
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
        $statusmsg = __('Moduł zdezaktywowany');
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
        $statusmsg = __('Moduł usunięty');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->modules->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('index-modules')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($module_slug, $slug)
    {
        Session::put('cms_locale_module_'.$module_slug, $slug);
    }

    /**
     * Change component locale with redirect back.
     *
     * @return \Illuminate\Http\Response
     */
    public function changelocale($module_id, $slug)
    {
        $module = $this->modules->find($module_id);
        $this->locale($module->slug, $slug);
        return redirect()->back();
    }



}
