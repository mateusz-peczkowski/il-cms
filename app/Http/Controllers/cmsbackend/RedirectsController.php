<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreRedirect;
use App\Http\Requests\UpdateRedirect;
use App\Repositories\Contracts\RedirectRepositoryInterface;
use Auth;

class RedirectsController extends BackendController
{
    public function __construct(RedirectRepositoryInterface $redirects)
    {
        parent::__construct();
        $this->middleware('admins');
        $this->redirects = $redirects;
    }

    /**
     * Show the application redirects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Przekierowania'), '/cmsbackend/settings/redirects');

        $redirects = $this->redirects->paginatedRedirects();
        return view('cmsbackend.redirects.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Przekierowania'),
            'redirects' => $redirects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role < 2) {
            $statusmsg = __('Nie posiadasz uprawnień do tworzenia przekierowań');
            return redirect()->route('redirects')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Przekierowania'), '/cmsbackend/settings/redirects');
        $this->breadcrumbs->addCrumb(__('Dodaj przekierowanie'), '/cmsbackend/settings/redirects/create');
        return view('cmsbackend.redirects.create')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Dodaj przekierowanie')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRedirect  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedirect $request)
    {
        if (!$this->redirects->checkRedirectExist($request->redirect_from)) {
            if($request->redirect_from == $request->redirect_to) {
                return redirect()->route('redirects.create')->with([
                    'status' => __('Nie można przekierować z takiego samego adresu na jaki przekierowujemy'),
                    'status_type' => 'danger'
                ])->withInput();
            }
            $this->redirects->create([
                'from' => $request->redirect_from,
                'to' => $request->redirect_to,
                'status' => 1
            ]);
            return redirect()->route('redirects')->with([
                'status' => __('Przekierowanie zostało dodane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('redirects.create')->with([
            'status' => __('Przekierowanie z podanego adresu już istnieje'),
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
        $redirect = $this->redirects->find($id);
        if(Auth::user()->role < 2) {
            $statusmsg = __('Nie posiadasz uprawnień do edycji przekierowań');
            return redirect()->route('redirects')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Przekierowania'), '/cmsbackend/settings/redirects');
        $this->breadcrumbs->addCrumb(__('Edytuj przekierowanie'), '/cmsbackend/settings/redirects/'.$id.'/edit');
        return view('cmsbackend.redirects.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj przekierowanie'),
            'redirect' => $redirect
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRedirect  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedirect $request, $id = null)
    {
        if($this->redirects->find($id)->from == $request->redirect_from || !$this->redirects->checkRedirectExist($request->redirect_from)) {
            if($request->redirect_from == $request->redirect_to) {
                return redirect()->route('redirects.edit', $id)->with([
                    'status' => __('Nie można przekierować z takiego samego adresu na jaki przekierowujemy'),
                    'status_type' => 'danger'
                ])->withInput();
            }
            $this->redirects->update([
                'from' => $request->redirect_from,
                'to' => $request->redirect_to
            ], $id);
            return redirect()->route('redirects')->with([
                'status' => __('Przekierowanie zostało zaaktualizowane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('redirects.edit', $id)->with([
            'status' => __('Przekierowanie z tego adresu już istnieje w naszym systemie'),
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
        $statusmsg = __('Przekierowanie aktywowane');
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
        $statusmsg = __('Przekierowanie zdezaktywowane');
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
        $statusmsg = __('Przekierowanie usunięte');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->redirects->update([
            'status' => $status
        ], $id);
        return redirect()->route('redirects')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }
}
