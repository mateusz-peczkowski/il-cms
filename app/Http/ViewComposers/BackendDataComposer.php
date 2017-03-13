<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Auth;

class BackendDataComposer
{
    /**
     * The user repository implementation.
     *
     * @var BackendDataComposer
     */
    protected $current_user;
    protected $current_user_attempt_success;
    protected $current_user_attempt_error;
    protected $current_user_role;
    protected $current_user_role_id;

    /**
     * Create a new profile composer.
     *
     * @param  BackendDataComposer  $current_user
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->user = Auth::user();
        if($this->user) {
            $this->current_user_attempt_success = $this->user->last_attmept_success;
            $this->current_user_attempt_error = $this->user->last_attmept_error;
            $this->userrole_id = $this->user->role;
            $this->userrole = $this->user->user_role;
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(!$this->user) {
            Auth::logout();
            return redirect()->route('login');
        }
        $view->with([
            'current_user' => $this->user,
            'current_user_role' => $this->userrole,
            'current_user_role_id' => $this->userrole_id,
            'current_user_attempt_success' => $this->current_user_attempt_success,
            'current_user_attempt_error' => $this->current_user_attempt_error
        ]);
    }
}