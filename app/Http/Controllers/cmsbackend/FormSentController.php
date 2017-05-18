<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Contracts\SubmitRepositoryInterface;
use Auth;
use Session;
use CMS;

class FormSentController extends BackendController
{
    public function __construct(FormRepositoryInterface $forms, SubmitRepositoryInterface $submits)
    {
        parent::__construct();
        $this->forms = $forms;
        $this->submits = $submits;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Wysłane'), '/cmsbackend/forms/sent');

        $forms = $this->forms->paginatedForms();
        return view('cmsbackend.form_sent.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Wysłane'),
            'forms' => $forms
        ]);
    }

    /**
     * Show the application details of resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = $this->forms->find($id);

        $submits = $this->submits->findBy('form_id', $id)->orderBy('id', 'desc')->paginate();

        $this->breadcrumbs->addCrumb(__('Formularze'), '/cmsbackend/forms/definitions');
        $this->breadcrumbs->addCrumb(__('Wysłane'), '/cmsbackend/forms/sent');
        $this->breadcrumbs->addCrumb($form->title.' - '.__('Wysłane'), '/cmsbackend/forms/sent/'.$id);

        return view('cmsbackend.form_sent.show')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => $form->title.' - '.__('Wysłane'),
            'form_id' => $id,
            'submits' => $submits
        ]);
    }

}
