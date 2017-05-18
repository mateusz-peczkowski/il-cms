<?php

namespace App\Repositories\Control;

use App\Repositories\Contracts\ControlRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentControlRepository extends AbstractRepository implements ControlRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Control';
    }

    function getPaginatedByFormID($id = null, $paggLimit = 15)
    {
        return $this->model
            ->where('form_id', '=', $id)
            ->paginate($paggLimit);
    }

}