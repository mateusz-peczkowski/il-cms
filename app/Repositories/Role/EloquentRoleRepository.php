<?php

namespace App\Repositories\Role;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentRoleRepository extends AbstractRepository implements RoleRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Role';
    }

    function listAllRoles()
    {
        return $this->model
            ->orderBy('id', 'asc')
            ->get();
    }

}