<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreForm;
use App\Http\Requests\UpdateForm;
use App\Repositories\Contracts\FormRepositoryInterface;
use Auth;
use Session;
use CMS;

class FormsController extends BackendController
{
    public function __construct(FormRepositoryInterface $forms)
    {
        parent::__construct();
        $this->forms = $forms;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Definicje'), '/cmsbackend/forms/definitions');

        $forms = $this->forms->paginatedForms();
        return view('cmsbackend.forms.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Definicje'),
            'forms' => $forms,
            'statusksadmasd' => __('Formularz został dodany'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanguage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForm $request)
    {
        $this->forms->create([
            'title' => $request->title,
            'tag' => $request->tag,
            'type' => $request->type,
            'description' => $request->description,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'confirmation' => $request->confirmation ? 1 : 0,
            'status' => 1,
            'who_updated' => Auth::id()
        ]);
        return redirect()->route('forms.definition')->with([
            'status' => __('Formularz został dodany'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit created resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = $this->forms->find($id);
        if(Auth::user()->role < 2) {
            return redirect()->route('forms.definition')->with([
                'status' => __('Nie posiadasz uprawnień do edycji opcji'),
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Definicje'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Edytuj formularz'), '/cmsbackend/forms/definitions/'.$id.'/edit');
        return view('cmsbackend.forms.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj formularz'),
            'form' => $form
        ]);
    }

    /**
     * Edit created resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateForm $request)
    {
        $this->forms->update([
            'title' => $request->title,
            'tag' => $request->tag,
            'type' => $request->type,
            'description' => $request->description,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
            'confirmation' => $request->confirmation ? 1 : 0,
            'status' => 1,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('forms.definition')->with([
            'status' => __('Formularz został zaaktualizowany'),
            'status_type' => 'success'
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
        $statusmsg = __('Formularz aktywowany');
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
        $statusmsg = __('Formularz zdezaktywowany');
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
        $statusmsg = __('Formularz usunięty');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->forms->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('forms.definition')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }



}
