<?php

namespace App\Repositories\PageOption;

use App\Repositories\Contracts\PageOptionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentPageOptionRepository extends AbstractRepository implements PageOptionRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\PageOption';
    }


}