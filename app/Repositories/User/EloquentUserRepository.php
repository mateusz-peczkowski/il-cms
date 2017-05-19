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

    public function paginatedUsers($paggLimit = 15)
    {
        return $this->model
            ->with('updater', 'user_role')
            ->where('status', '<', 3)
            ->orderBy('role', 'desc')
            ->orderBy('name', 'asc')
            ->paginate($paggLimit);
    }

    public function paginatedUsersTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    public function checkUserEmailExist($email = false)
    {
        return $this->model
            ->where('email', '=', $email)
            ->count();
    }

    public function findByIdAndToken($identifier, $token)
    {
        return $this->model
            ->where($this->model->getKeyName(), $identifier)
            ->where($this->model->getrememberTokenName(), $token)
            ->first();
    }

    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->model->newQuery();

        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password'))
                $query->where($key, $value);
        }

        return $query->first();
    }

}