<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreControl;
use App\Http\Requests\UpdateControl;
use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Contracts\ControlRepositoryInterface;
use Auth;
use Session;
use CMS;

class ControlsController extends BackendController
{
    public function __construct(FormRepositoryInterface $forms, ControlRepositoryInterface $controls)
    {
        parent::__construct();
        $this->forms = $forms;
        $this->controls = $controls;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $form = $this->forms->find($id);
        $controls = $this->controls->getPaginatedByFormID($id);

        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Definicje'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb($form->title.' - '.__('Kontrolki'), '/cmsbackend/forms/definitions/'.$id.'/controls');

        return view('cmsbackend.controls.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => $form->title.' - '.__('Kontrolki'),
            'form' => $form,
            'controls' => $controls
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanguage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreControl $request)
    {
        $last = $this->controls->findBy('form_id', $request->form_id) ? $this->controls->findBy('form_id', $request->form_id)->orderBy('order', 'desc')->first() : false;
        $order = $last ? $last->order+1 : '1';
        $this->controls->create([
            'label' => $request->label,
            'name' => $request->name,
            'type' => $request->type,
            'default' => $request->default,
            'values' => $request->values,
            'required' => $request->required ? 1 : 0,
            'form_id' => $request->form_id,
            'status' => 1,
            'who_updated' => Auth::id(),
            'order' => $order
        ]);
        return redirect()->route('forms.definition.controls', $request->form_id)->with([
            'status' => __('Kontrolka została dodana'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit created resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($form_id, $control_id)
    {
        $form = $this->forms->find($form_id);
        $control = $this->controls->find($control_id);
        if(Auth::user()->role < 2) {
            return redirect()->route('forms.definition.controls')->with([
                'status' => __('Nie posiadasz uprawnień do edycji kontrolek'),
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Definicje'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb($form->title.' - '.__('Kontrolki'), '/cmsbackend/forms/definitions/'.$form_id.'/controls');
        $this->breadcrumbs->addCrumb(__('Edytuj kontrolkę'), '/cmsbackend/forms/definitions/'.$form_id.'/controls/'.$control_id);
        return view('cmsbackend.controls.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj kontrolkę'),
            'form' => $form,
            'control' => $control
        ]);
    }

    /**
     * Edit created resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($form_id, $control_id, UpdateControl $request)
    {
        $this->controls->update([
            'label' => $request->label,
            'name' => $request->name,
            'type' => $request->type,
            'default' => $request->default,
            'values' => $request->values,
            'required' => $request->required ? 1 : 0,
            'status' => 1,
            'who_updated' => Auth::id()
        ], $control_id);
        return redirect()->route('forms.definition.controls', $form_id)->with([
            'status' => __('Kontrolka została zaaktualizowana'),
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
        $form_id = $this->controls->find($id)->form_id;

        $this->controls->destroy($id);

        return redirect()->route('forms.definition.controls', $form_id)->with([
            'status' => __('Element usunięty'),
            'status_type' => 'danger'
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
        $statusmsg = __('Kontrolka aktywowana');
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
        $statusmsg = __('Kontrolka zdezaktywowana');
        return $this->change_status($id, 2, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->controls->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        $control = $this->controls->find($id);
        return redirect()->route('forms.definition.controls', $control->form_id)->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

}
