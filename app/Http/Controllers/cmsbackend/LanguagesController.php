<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreLanguage;
use App\Http\Requests\UpdateLanguage;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Auth;
use Session;
use App;

class LanguagesController extends BackendController
{
    public function __construct(LanguageRepositoryInterface $languages)
    {
        parent::__construct();
        $this->languages = $languages;
    }

    /**
     * Show the application languages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Języki'), '/cmsbackend/settings/languages');

        $languages = $this->languages->paginatedLanguages();
        return view('cmsbackend.languages.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Języki'),
            'languages' => $languages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanguage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguage $request)
    {
        if (!$this->languages->checkLanguageExist($request->language_slug)) {
            if($request->language_is_default)
            {
                $old_default = $this->languages->findBy('is_default', '1');
                if($old_default) {
                    $this->languages->update([
                        'is_default' => '0'
                    ], $old_default->id);
                }
            }
            $obj = [];
            $obj['title'] = $request->language_title;
            $obj['slug'] = $request->language_slug;
            $obj['status'] = 1;
            $obj['order'] = $this->languages->allLanguagesCount()+1;
            $obj['who_updated'] = Auth::id();
            $obj['is_default'] = '0';
            if($request->language_is_default) {
                $obj['is_default'] = '1';
                App::setLocale($obj['slug']);
                Session::put('cms_locale', $obj['slug']);
            }
            $this->languages->create($obj);
            return redirect()->route('languages')->with([
                'status' => __('Język został dodany'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('languages')->with([
            'status' => __('Język z podanym slugiem istnieje w systemie'),
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
        $language = $this->languages->find($id);
        if(Auth::user()->role < 2) {
            $statusmsg = __('Nie posiadasz uprawnień do edycji języków');
            return redirect()->route('languages')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Języki'), '/cmsbackend/settings/languages');
        $this->breadcrumbs->addCrumb(__('Edytuj język'), '/cmsbackend/settings/languages/'.$id.'/edit');
        return view('cmsbackend.languages.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj język'),
            'language' => $language
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLanguage  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguage $request, $id = null)
    {
        if($this->languages->find($id)->title == $request->language_title || !$this->languages->checkLanguageExist($request->language_slug)) {
            if($request->language_is_default)
            {
                $old_default = $this->languages->findBy('is_default', '1');
                if($old_default) {
                    $this->languages->update([
                        'is_default' => '0'
                    ], $old_default->id);
                }
            }
            $obj = [];
            $obj['title'] = $request->language_title;
            $obj['slug'] = $request->language_slug;
            $obj['who_updated'] = Auth::id();
            $obj['is_default'] = '0';
            if($request->language_is_default || $this->languages->find($id)->is_default) {
                $obj['is_default'] = '1';
                App::setLocale($obj['slug']);
                Session::put('cms_locale', $obj['slug']);
            }
            $this->languages->update($obj, $id);
            return redirect()->route('languages')->with([
                'status' => __('Język został zaaktualizowany'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('languages.edit', $id)->with([
            'status' => __('Język z podanym slugiem istnieje w systemie'),
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
        $statusmsg = __('Język aktywowany');
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
        $statusmsg = __('Język zdezaktywowany');
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
        $statusmsg = __('Język usunięty');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        if($this->languages->find($id)->is_default)
        {
            return redirect()->route('languages')->with([
                'status' => __('Nie można zmienić statusu języka domyślnego'),
                'status_type' => 'danger'
            ]);
        }
        if($this->languages->find($id)->slug == Session::get('cms_locale'))
        {
            App::setLocale($this->languages->findBy('is_default', '1')->slug);
            Session::put('cms_locale', $this->languages->findBy('is_default', '1')->slug);
        }
        $this->languages->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('languages')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }
}
