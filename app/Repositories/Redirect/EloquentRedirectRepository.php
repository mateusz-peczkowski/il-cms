<?php

namespace App\Repositories\Redirect;

use App\Repositories\Contracts\RedirectRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentRedirectRepository extends AbstractRepository implements RedirectRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Redirect';
    }

    function paginatedRedirects($paggLimit = 15)
    {
        return $this->model
            ->where('status', '<', 3)
            ->orderBy('from', 'desc')
            ->paginate($paggLimit);
    }

    function paginatedRedirectsTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkRedirectExist($from = false)
    {
        $from = $this->model
            ->where('from', '=', $from)
            ->first();
        if($from) {
            return true;
        } else {
            return false;
        }
    }

}