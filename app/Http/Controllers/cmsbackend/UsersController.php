<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateCurrentUser;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use Auth;

class UsersController extends BackendController
{
    public function __construct(UserRepositoryInterface $user, RoleRepositoryInterface $role)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->required_role = $this->role->find(3);
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginatedUsers();
        $this->breadcrumbs->addCrumb(__('Użytkownicy'), '/cmsbackend/users');
        return view('cmsbackend.users.index')->with([
            'users' => $users,
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Użytkownicy'),
            'required_role' => $this->required_role
        ]);
    }

    /**
     * Show the form for creating new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role < $this->required_role->id) {
            $statusmsg = __('Nie posiadasz uprawnień do tworzenia użytkowników');
            return redirect()->route('users')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Użytkownicy'), '/cmsbackend/users');
        $this->breadcrumbs->addCrumb(__('Dodaj użytkownika'), '/cmsbackend/users/create');
        return view('cmsbackend.users.create')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Dodaj użytkownika'),
            'roles' => $this->role->listAllRoles()
        ]);
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        if (!$this->user->checkUserEmailExist($request->user_email)) {
            $this->user->create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'password' => Hash::make($request->user_password),
                'role' => $request->user_role,
                'image' => Gravatar::src($request->user_email, ['width' => 250, 'height' => 250]),
                'status' => 1
            ]);
            return redirect()->route('users')->with([
                'status' => __('Użytkownik został stworzony. Jego konto jest już aktywne i może się zalogować'),
                'status_type' => 'success'
            ]);
        } else {
            return redirect()->route('users.create')->with([
                'status' => __('Użytkownik o podanym adresie e-mail istnieje'),
                'status_type' => 'danger'
            ])->withInput(
                $request->except('password')
            );
        }
    }


    /**
     * Show the form for creating new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        if(Auth::user()->role < $this->required_role->id || Auth::user()->role < $user->role) {
            $statusmsg = __('Nie posiadasz uprawnień do edycji użytkowników');
            return redirect()->route('users')->with([
                'status' => $statusmsg,
                'status_type' => 'danger'
            ]);
        }
        $this->breadcrumbs->addCrumb(__('Użytkownicy'), '/cmsbackend/users');
        $this->breadcrumbs->addCrumb(__('Edytuj użytkownika'), '/cmsbackend/users/'.$id.'/edit');
        return view('cmsbackend.users.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj użytkownika'),
            'roles' => $this->role->listAllRoles(),
            'user' => $user
        ]);
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id = null)
    {
        if($this->user->find($id)->email == $request->user_email || !$this->user->checkUserEmailExist($request->user_email)) {
            $obj = [];
            $obj['name'] = $request->user_name;
            $obj['email'] = $request->user_email;
            $obj['role'] = $request->user_role;
            if($request->user_password) {
                $obj['password'] = Hash::make($request->user_password);
            }
            $this->user->update($obj, $id);
            return redirect()->route('users')->with([
                'status' => __('Dane użytkownika zostały zaktualizowane'),
                'status_type' => 'success'
            ]);
        } else {
            return redirect()->route('users.edit', $id)->with([
                'status' => __('Użytkownik o podanym adresie e-mail istnieje'),
                'status_type' => 'danger'
            ])->withInput(
                $request->except('password')
            );
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $statusmsg = __('Użytkownik aktywowany');
        return $this->change_status($id, 1, $statusmsg, 'success');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $statusmsg = __('Użytkownik zdezaktywowany');
        return $this->change_status($id, 2, $statusmsg, 'success');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $statusmsg = __('Użytkownik usunięty');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    public function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->user->update([
            'status' => $status
        ], $id);
        return redirect()->route('users')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
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
        if(!$request->photo && $request->photo_gravatar) {
            return redirect()->route('dashboard')->with([
                'status' => __('Twoje zdjęcie zostało dodane'),
                'status_type' => 'error'
            ]);
        }
        if($request->photo_gravatar) {
            $obj['image'] = Gravatar::src(Auth::user()->email, ['width' => 250, 'height' => 250]);
        } else {
            $newname = time().'-'.Auth::user()->id.'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('data/user'), $newname);
            $obj['image'] = '/data/user/'.$newname;
        }
        $this->user->update($obj, Auth::user()->id);
        return redirect()->route('dashboard')->with('status', __('Twoje zdjęcie zostało dodane'));
    }
}
