<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\UpdateCurrentUser;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
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
        $obj = [];
        if($request->photo_gravatar AND Gravatar::exists(Auth::user()->email)) {
            $obj['image'] = Gravatar::src(Auth::user()->email, ['width' => 250, 'height' => 250]);
        } else {
            $newname = time().'-'.Auth::user()->id.'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('data/user'), $newname);
            $obj['image'] = '/data/user/'.$newname;
        }
        $this->user->update($obj, Auth::user()->id);
        return redirect()->route('dashboard')->with('status', __('Twoje zdjęcie zostało dodane'));
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
