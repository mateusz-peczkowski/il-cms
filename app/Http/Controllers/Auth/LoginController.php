<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\StoreModule;
use App\Repositories\Contracts\LoginAttemptsRepositoryInterface as LoginAttemptsRepositoryInterface;
use App\Http\Controllers\cmsbackend\BackendController as BackendController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BackendController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cmsbackend';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginAttemptsRepositoryInterface $loginAttempts)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->loginAttempts = $loginAttempts;
    }

    /**
     * Store a login attempts in storage.
     *
     * @param  \App\Http\Requests\StoreLoginAttempts  $request
     * @return \Illuminate\Http\Response
     */
    protected function attemptLogin($request)
    {
        if ($this->guard()->attempt($this->credentials($request), $request->has('remember'))) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->loginAttempts->create([
            'user_email' => $request->email,
            'status' => $status,
            'login_ip' => $request->ip(),
        ]);
        return $status == 'success' ? true : false;
    }

    protected function credentials($request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }
}
