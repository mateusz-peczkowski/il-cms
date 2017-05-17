<?php

namespace App\Repositories\Form;

use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentFormRepository extends AbstractRepository implements FormRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Form';
    }

    function paginatedForms($paggLimit = 15)
    {
        return $this->model
            ->where('status', '<', 3)
            ->paginate($paggLimit);
    }

}