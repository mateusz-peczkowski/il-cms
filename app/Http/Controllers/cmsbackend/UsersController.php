<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\UpdateCurrentUser;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile as file;
use Auth;

class UsersController extends BackendController
{
    public function __construct(UserRepositoryInterface $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Update current resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCurrentUser  $request
     * @return \Illuminate\Http\Response
     */
    public function editcurrent(UpdateCurrentUser $request)
    {
        $obj = [];
        $obj['name'] = $request->user_name;
        $obj['email'] = $request->user_email;
        $user_email = Auth::user()->email;
        if($request->user_password) {
            $obj['password'] = Hash::make($request->user_password);
        }
        $this->user->update($obj, Auth::user()->id);
        if($user_email == $obj['email'] && !$request->user_password) {
            return redirect()->route('dashboard')->with('status', __('Twoje dane zostały zaktualizowane'));
        }
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Update current resource avatar in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function addavatar(Request $request)
    {
        dd($request->photo->store('images'));
        dd($request->file('photo'));
//        $obj = [];
//        $obj['name'] = $request->user_name;
//        $obj['email'] = $request->user_email;
//        $user_email = Auth::user()->email;
//        if($request->user_password) {
//            $obj['password'] = Hash::make($request->user_password);
//        }
//        $this->user->update($obj, Auth::user()->id);
//        if($user_email == $obj['email'] && !$request->user_password) {
//            return redirect()->route('dashboard')->with('status', __('Twoje dane zostały zaktualizowane'));
//        }
//        Auth::logout();
//        return redirect()->route('login');
    }
}
