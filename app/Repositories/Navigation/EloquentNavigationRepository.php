<?php

namespace App\Repositories\Navigation;

use App\Repositories\Contracts\NavigationRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentNavigationRepository extends AbstractRepository implements NavigationRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Navigation';
    }

    public function getActive()
    {
        return $this->model
            ->with('updater')
            ->where('status', '=', 1)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function paginatedNavigations($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '<', 3)
            ->orderBy('order', 'asc')
            ->paginate($paggLimit);
    }

    public function paginatedNavigationsTrash($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

}