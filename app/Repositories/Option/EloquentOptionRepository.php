<?php

namespace App\Repositories\Option;

use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentOptionRepository extends AbstractRepository implements OptionRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Option';
    }

    function getByType($type = '', $locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('type', $type)
            ->where('locale', $locale)
            ->orderBy('id', 'asc')
            ->get();
    }

    function getByTypePaginated($type = '', $locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('type', $type)
            ->where('locale', $locale)
            ->orderBy('id', 'asc')
            ->paginate($paggLimit);
    }

    function checkOptionExist($key = '', $locale = '')
    {
        return $this->model
            ->where('key', $key)
            ->where('locale', $locale)
            ->count();
    }

}