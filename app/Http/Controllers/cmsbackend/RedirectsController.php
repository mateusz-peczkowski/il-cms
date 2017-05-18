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
        $this->redirects = $redirects;
    }

    /**
     * Show the application resources.
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRedirect  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedirect $request)
    {
        if (!$this->redirects->checkRedirectExist($request->redirect_from)) {
            if($request->redirect_from == $request->redirect_to) {
                return redirect()->route('redirects')->with([
                    'status' => __('Nie można przekierować z takiego samego adresu na jaki przekierowujemy'),
                    'status_type' => 'danger'
                ])->withInput();
            }
            $this->redirects->create([
                'from' => $request->redirect_from,
                'to' => $request->redirect_to,
                'status' => 1,
                'who_updated' => Auth::id()
            ]);
            return redirect()->route('redirects')->with([
                'status' => __('Przekierowanie zostało dodane'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('redirects')->with([
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
                'to' => $request->redirect_to,
                'who_updated' => Auth::id()
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
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('redirects')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }
}
