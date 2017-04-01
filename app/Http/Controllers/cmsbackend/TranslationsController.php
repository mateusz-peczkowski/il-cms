<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreTranslation;
use App\Http\Requests\UpdateTranslation;
use App\Repositories\Contracts\TranslationRepositoryInterface;
use Auth;

class TranslationsController extends BackendController
{
    public function __construct(TranslationRepositoryInterface $translations)
    {
        parent::__construct();
        $this->translations = $translations;
    }

    /**
     * Show the application translations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Tłumaczenia'), '/cmsbackend/settings/translations');

        $translations = $this->translations->paginatedTranslations();
        return view('cmsbackend.translations.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Tłumaczenia'),
            'translations' => $translations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTranslation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTranslation $request)
    {
        if (!$this->translations->checkTranslationExist($request->translation_key)) {
            $this->translations->create([
                'key' => $request->translation_key,
                'value' => $request->translation_value,
                'status' => 1,
                'who_updated' => Auth::id()
            ]);
            return redirect()->route('translations')->with([
                'status' => __('Tłumaczenie zostało dodane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('translations')->with([
            'status' => __('Tłumaczenie już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $translation = $this->translations->find($id);
        if(Auth::user()->role < 2) {
            $statusmsg = __('Nie posiadasz uprawnień do edycji tłumaczeń');
            return redirect()->route('translations')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Tłumaczenia'), '/cmsbackend/settings/translations');
        $this->breadcrumbs->addCrumb(__('Edytuj tłumaczenie'), '/cmsbackend/settings/translations/'.$id.'/edit');
        return view('cmsbackend.translations.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj tłumaczenie'),
            'translation' => $translation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTranslation  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTranslation $request, $id = null)
    {
        if($this->translations->find($id)->from == $request->translation_key || !$this->translations->checkTranslationExist($request->translation_key)) {
            $this->translations->update([
                'key' => $request->translation_key,
                'value' => $request->translation_value,
                'who_updated' => Auth::id()
            ], $id);
            return redirect()->route('translations')->with([
                'status' => __('Tłumaczenie zostało zaaktualizowane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('translations.edit', $id)->with([
            'status' => __('Tłumaczenie już istnieje w systemie'),
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
        $statusmsg = __('Tłumaczenie aktywowane');
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
        $statusmsg = __('Tłumaczenie zdezaktywowane');
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
        $statusmsg = __('Tłumaczenie usunięte');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->translations->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('translations')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }
}
