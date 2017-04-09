<?php

namespace App\Repositories\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentUserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\User';
    }

    public function allUsersCount()
    {
        return $this->model->count();
    }

    function paginatedUsers($paggLimit = 15)
    {
        return $this->model
            ->where('status', '<', 3)
            ->orderBy('role', 'desc')
            ->orderBy('name', 'asc')
            ->paginate($paggLimit);
    }

    function paginatedUsersTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkUserEmailExist($email = false)
    {
        return $this->model
            ->where('email', '=', $email)
            ->count();
    }

}