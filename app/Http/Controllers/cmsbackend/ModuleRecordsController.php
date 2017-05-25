<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreRecordModule;
use App\Http\Requests\UpdateRecordModule;
use App\Http\Requests\StoreModuleRecordDuplicate;
use App\Repositories\Contracts\ModuleRepositoryInterface;
use App\Repositories\Contracts\ModuleRecordRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Auth;
use Session;
use CMS;

class ModuleRecordsController extends BackendController
{
    public function __construct(ModuleRepositoryInterface $modules, ModuleRecordRepositoryInterface $module_records, LanguageRepositoryInterface $languages)
    {
        parent::__construct();
        $this->modules = $modules;
        $this->module_records = $module_records;
        $this->languages = $languages;
    }

    /**
     * Show the application resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $module = $this->modules->find($id);
        $order_method = $module->order_records;
        $order_method_type = $order_method == 'order' ? 'desc' : $module->order_records_type;
        $records = $this->module_records->paginateByModule($order_method, $order_method_type, $id, $this->checkLocale($module->slug));
        $this->breadcrumbs->addCrumb(__('Moduł').' - '.__($module->title), '/cmsbackend/modules/'.$id);
        return view('cmsbackend.module_records.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Moduł').' - '.__($module->title),
            'module' => $module,
            'records' => $records,
            'is_active_nav' => 'modules-'.$module->slug,
            'all_languages' => $this->languages->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\StoreRecordModule  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StoreRecordModule $request)
    {
        $module = $this->modules->find($id);
        $obj = $request->only('title', 'data');
        $data_send = [];
        if($obj['data']) {
            foreach($obj['data'] as $key => $value) {
                if($value != null) {
                    if(gettype($value) == 'object') {
                        $dot = $value->getClientOriginalExtension() ? '.'.$value->getClientOriginalExtension() : '';
                        $newname = str_slug(pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().$dot;
                        if(!file_exists(public_path('source/modules/'.$module->id))) {
                            mkdir(public_path('source/modules/'.$module->id), 0777, true);
                            chmod(public_path('source/modules/'.$module->id), 0777);
                        }
                        $value->move(public_path('source/modules/'.$module->id), $newname);
                        $data_send[$key] = '/source/modules/'.$module->id.'/'.$newname;
                    } else {
                        $data_send[$key] = $value;
                    }
                }
            }
        }
        $last = $this->module_records->allByLang($this->checkLocale($module->slug))->count() ? $this->module_records->allByLang($this->checkLocale($module->slug))->first() : false;
        $order = $last ? $last->order+1 : '1';
        $this->module_records->create([
            'title' => $obj['title'],
            'slug' => $this->constructSlug(0, $obj['title']),
            'data' => json_encode($data_send),
            'module_id' => $id,
            'status' => 1,
            'order' => $order,
            'locale' => $this->checkLocale($module->slug),
            'who_updated' => Auth::id()
        ]);
        return redirect()->route('records', $id)->with([
            'status' => __('Rekord został dodany'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($module_id, $id)
    {
        $module = $this->modules->find($module_id);
        $record = $this->module_records->find($id);
        $this->breadcrumbs->addCrumb(__('Moduł').' - '.__($module->title), '/cmsbackend/modules/'.$module_id);
        $this->breadcrumbs->addCrumb(__('Edycja rekordu'), '/cmsbackend/modules/'.$module_id.'/'.$id);
        return view('cmsbackend.module_records.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edycja rekordu'),
            'module' => $module,
            'record' => $record,
            'is_active_nav' => 'modules-'.$module->slug
        ]);
    }

    /**
     * update created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdateModule  $request
     * @return \Illuminate\Http\Response
     */
    public function update($module_id, $id, UpdateRecordModule  $request)
    {
        $module = $this->modules->find($module_id);
        $record = $this->module_records->find($id);
        $obj = $request->only('title', 'data');
        $data_send = [];
        if($obj['data']) {
            foreach ($obj['data'] as $key => $value) {
                if ($value != null) {
                    if (gettype($value) == 'object') {
                        $dot = $value->getClientOriginalExtension() ? '.' . $value->getClientOriginalExtension() : '';
                        $newname = str_slug(pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . $dot;
                        if (!file_exists(public_path('source/modules/' . $module->id))) {
                            mkdir(public_path('source/modules/' . $module->id), 0777, true);
                            chmod(public_path('source/modules/' . $module->id), 0777);
                        }
                        $value->move(public_path('source/modules/' . $module->id), $newname);
                        $data_send[$key] = '/source/modules/' . $module->id . '/' . $newname;
                    } else {
                        $data_send[$key] = $value;
                    }
                }
            }
        }
        $obj_send = [
            'title' => $obj['title'],
            'data' => json_encode($data_send),
            'who_updated' => Auth::id()
        ];
        if($obj['title'] != $record->title) {
            $obj_send['slug'] = $this->constructSlug(0, $obj['title']);
        }
        $this->module_records->update($obj_send, $id);
        return redirect()->route('records', $module_id)->with([
            'status' => __('Rekord został zaaktualizowany'),
            'status_type' => 'success'
        ]);

    }

    /**
     * Duplicate the specified resource in storage of another lang.
     *
     * @param  \App\Http\Requests\UpdateOption  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id, StoreModuleRecordDuplicate $request)
    {
        $duplicate = $this->module_records->find($request->record_id);
        $module = $this->modules->find($id);
        $last = $this->module_records->allByLang($request->form_language)->count() ? $this->module_records->allByLang($request->form_language)->first() : false;
        $order = $last ? $last->order+1 : '1';
        $this->module_records->create([
            'title' => $duplicate->title,
            'slug' => $this->constructSlug(0, $duplicate->title),
            'data' => $duplicate->data,
            'module_id' => $id,
            'order' => $order,
            'status' => 2,
            'who_updated' => Auth::id(),
            'locale' => $request->form_language
        ]);
        if($request->form_language != $this->checkLocale($module->slug)) {
            $this->locale($module->slug, $request->form_language);
        }
        return redirect()->route('records', $id)->with([
            'status' => __('Formularz został skopiowany'),
            'status_type' => 'success'
        ]);
    }

    private function constructSlug($num, $name) {
        if($num) {
            $slug = str_slug($name).'-'.$num;
        } else {
            $slug = str_slug($name);
        }
        if($this->module_records->findBy('slug', $slug)) {
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
    public function activate($module_id, $id)
    {
        $statusmsg = __('Rekord aktywowany');
        return $this->change_status($id, 1, $statusmsg, 'success', $module_id);
    }

    /**
     * Deactivate the specified resource at storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($module_id, $id)
    {
        $statusmsg = __('Rekord zdezaktywowany');
        return $this->change_status($id, 2, $statusmsg, 'success', $module_id);
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype, $module_id)
    {
        $this->module_records->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('records', $module_id)->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($module_id, $id)
    {
        $this->module_records->destroy($id);

        return redirect()->route('records', $module_id)->with([
            'status' => __('Element usunięty'),
            'status_type' => 'danger'
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
     * Check component locale.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkLocale($slug)
    {
        if(Session::has('cms_locale_module_'.$slug) && CMS::isLocale(Session::get('cms_locale_module_'.$slug))) {
            return Session::get('cms_locale_module_'.$slug);
        }
        $this->locale($slug, CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }

}
