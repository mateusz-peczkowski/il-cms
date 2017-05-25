<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreTranslation;
use App\Http\Requests\UpdateTranslation;
use App\Http\Requests\StoreTranslationDuplicate;
use App\Repositories\Contracts\TranslationRepositoryInterface;
use Auth;
use Session;
use CMS;

class TranslationsController extends BackendController
{
    public function __construct(TranslationRepositoryInterface $translations)
    {
        parent::__construct();
        $this->translations = $translations;
    }

    /**
     * Show the application resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Tłumaczenia'), '/cmsbackend/settings/translations');

        $translations = $this->translations->paginatedTranslations($this->checkLocale());
        return view('cmsbackend.translations.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Tłumaczenia'),
            'translations' => $translations,
            'is_active_nav' => 'settings/translations'
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
        if (!$this->translations->checkTranslationExist($request->translation_key, $this->checkLocale())) {
            $this->translations->create([
                'key' => $request->translation_key,
                'value' => $request->translation_value,
                'status' => 1,
                'locale' => $this->checkLocale(),
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
            'translation' => $translation,
            'is_active_nav' => 'settings/translations'
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
        if($this->translations->find($id)->key == $request->translation_key || !$this->translations->checkTranslationExist($request->translation_key, $this->checkLocale())) {
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
     * Duplicate the specified resource in storage of another lang.
     *
     * @param  \App\Http\Requests\UpdateTranslation  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(StoreTranslationDuplicate $request)
    {
        $duplicate = $this->translations->find($request->translation_id);
        if($duplicate && !$this->translations->checkTranslationExist($duplicate->key, $request->translation_language)) {
            $this->translations->create([
                'key' => $duplicate->key,
                'value' => $duplicate->value,
                'status' => 1,
                'locale' => $request->translation_language,
                'who_updated' => Auth::id()
            ]);
            $this->locale($request->translation_language);
            return redirect()->route('translations')->with([
                'status' => __('Tłumaczenie zostało skopiowane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('translations')->with([
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

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($slug)
    {
        Session::put('cms_locale_translation', $slug);
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
        if(Session::has('cms_locale_translation') && CMS::isLocale(Session::get('cms_locale_translation'))) {
            return Session::get('cms_locale_translation');
        }
        $this->locale(CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }
}
