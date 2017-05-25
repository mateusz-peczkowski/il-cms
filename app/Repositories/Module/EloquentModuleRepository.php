<?php

namespace App\Repositories\Module;

use App\Repositories\Contracts\ModuleRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentModuleRepository extends AbstractRepository implements ModuleRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Module';
    }

    public function paginatedModules($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '<', 3)
            ->orderBy('order', 'asc')
            ->paginate($paggLimit);
    }

    public function paginatedModulesTrash($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

}