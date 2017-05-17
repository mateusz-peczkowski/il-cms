<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreForm;
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
     * Show the application options.
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



}
