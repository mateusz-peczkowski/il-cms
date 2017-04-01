<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user) {
        if($user->role === 4) {
            return true;
        }
    }

    public function revokeDestroy(User $user) {
        return $user->role >= 3;
    }

    public function add(User $user) {
        return $user->role >= 3;
    }

    public function add_dev(User $user) {
        return $user->role >= 2;
    }

    public function edit(User $user) {
        return $user->role >= 3;
    }

    public function edit_dev(User $user) {
        return $user->role >= 2;
    }

    public function seechangelog(User $user) {
        return $user->role >= 3;
    }

}
