<?php

namespace App\Repositories\Submit;

use App\Repositories\Contracts\SubmitRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentSubmitRepository extends AbstractRepository implements SubmitRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Submit';
    }

}