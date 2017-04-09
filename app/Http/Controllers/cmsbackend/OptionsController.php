<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreOption;
use App\Http\Requests\UpdateOption;
use App\Http\Requests\StoreOptionDuplicate;
use App\Repositories\Contracts\OptionRepositoryInterface;
use Auth;
use Session;
use CMS;

class OptionsController extends BackendController
{
    public function __construct(OptionRepositoryInterface $options)
    {
        parent::__construct();
        $this->options = $options;
    }

    /**
     * Show the application options.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Opcje'), '/cmsbackend/settings/options');

        $options = $this->options->getByTypePaginated('default', $this->checkLocale());
        return view('cmsbackend.options.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Opcje'),
            'options' => $options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanguage  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOption $request)
    {
        if (!$this->options->checkOptionExist($request->option_key, $this->checkLocale())) {
            $this->options->create([
                'key' => $request->option_key,
                'value' => $request->option_value,
                'type' => 'default',
                'locale' => $this->checkLocale(),
                'who_updated' => Auth::id()
            ]);
            return redirect()->route('options')->with([
                'status' => __('Opcja została dodana'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('options')->with([
            'status' => __('Opcja już istnieje w systemie'),
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
        $option = $this->options->find($id);
        if(Auth::user()->role < 2) {
            $statusmsg = __('Nie posiadasz uprawnień do edycji opcji');
            return redirect()->route('options')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Opcje'), '/cmsbackend/settings/options');
        $this->breadcrumbs->addCrumb(__('Edytuj opcje'), '/cmsbackend/settings/options/'.$id.'/edit');
        return view('cmsbackend.options.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj opcje'),
            'option' => $option
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOption  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOption $request, $id = null)
    {
        if($this->options->find($id)->key == $request->option_key || !$this->options->checkOptionExist($request->option_key, $this->checkLocale())) {
            $this->options->update([
                'key' => $request->option_key,
                'value' => $request->option_value,
                'who_updated' => Auth::id()
            ], $id);
            return redirect()->route('options')->with([
                'status' => __('Opcja została zaaktualizowana'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('options.edit', $id)->with([
            'status' => __('Opcja już istnieje w systemie'),
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
    public function duplicate(StoreOptionDuplicate $request)
    {
        $duplicate = $this->options->find($request->option_id);
        if($duplicate && !$this->options->checkOptionExist($duplicate->key, $request->option_language)) {
            $this->options->create([
                'type' => $duplicate->type,
                'key' => $duplicate->key,
                'value' => $duplicate->value,
                'locale' => $request->option_language,
                'who_updated' => Auth::id()
            ]);
            $this->locale($request->option_language);
            return redirect()->route('options')->with([
                'status' => __('Opcja została skopiowana'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('options')->with([
            'status' => __('Opcja już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
    }

    /**
     * @param  string  $module
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->options->destroy($id);

        return redirect()->route('options')->with([
            'status' => __('Opcja usunięta'),
            'status_type' => 'danger'
        ]);

    }

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($slug)
    {
        Session::put('cms_locale_option', $slug);
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
        if(Session::has('cms_locale_option') && CMS::isLocale(Session::get('cms_locale_option'))) {
            return Session::get('cms_locale_option');
        }
        $this->locale(CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }

}
