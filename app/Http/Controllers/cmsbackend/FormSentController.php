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

        $forms = $this->forms->paginatedForms($this->checkLocale());
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

        $submits = $this->submits->findBy('form_id', $id) ? $this->submits->getSubmitsByForm($id) : false;

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

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($slug)
    {
        Session::put('cms_locale_form', $slug);
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
        if(Session::has('cms_locale_form') && CMS::isLocale(Session::get('cms_locale_form'))) {
            return Session::get('cms_locale_form');
        }
        $this->locale(CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }

}
