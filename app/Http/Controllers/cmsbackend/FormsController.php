<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreForm;
use App\Http\Requests\UpdateForm;
use App\Http\Requests\StoreFormDuplicate;
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

        $forms = $this->forms->paginatedForms($this->checkLocale());
        return view('cmsbackend.forms.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Definicje'),
            'forms' => $forms
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
        if (!$this->forms->checkFormExist($request->tag, $this->checkLocale())) {
            $this->forms->create([
                'title' => $request->title,
                'tag' => $request->tag,
                'type' => $request->type,
                'description' => $request->description,
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'confirmation' => $request->confirmation ? 1 : 0,
                'status' => 1,
                'locale' => $this->checkLocale(),
                'who_updated' => Auth::id()
            ]);
            return redirect()->route('forms.definition')->with([
                'status' => __('Formularz został dodany'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('forms.definition')->with([
            'status' => __('Formularz o podanych danych już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
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
        if($this->forms->find($id)->tag == $request->tag || !$this->forms->checkFormExist($request->tag, $this->checkLocale())) {
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
        return redirect()->route('forms.definition.edit', $id)->with([
            'status' => __('Formularz o podanych danych już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
    }

    /**
     * Duplicate the specified resource in storage of another lang.
     *
     * @param  \App\Http\Requests\UpdateOption  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(StoreFormDuplicate $request)
    {
        $duplicate = $this->forms->find($request->form_id);
        if($duplicate && !$this->forms->checkFormExist($duplicate->tag, $request->form_language)) {
            $this->forms->create([
                'title' => $duplicate->title,
                'tag' => $duplicate->tag,
                'type' => $duplicate->type,
                'description' => $duplicate->description,
                'sender_name' => $duplicate->sender_name,
                'sender_email' => $duplicate->sender_email,
                'confirmation' => $duplicate->confirmation ? 1 : 0,
                'locale' => $request->form_language,
                'who_updated' => Auth::id()
            ]);
            $this->locale($request->form_language);
            return redirect()->route('forms.definition')->with([
                'status' => __('Formularz został skopiowany'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('forms.definition')->with([
            'status' => __('Formularz już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
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
