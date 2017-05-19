<?php

namespace App\Repositories\Option;

use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Support\Facades\Config;

class EloquentOptionRepository extends AbstractRepository implements OptionRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Option';
    }

    public function getByType($type = '', $locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('type', $type)
            ->where('locale', $locale)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getByTypePaginated($type = '', $locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('type', $type)
            ->where('locale', $locale)
            ->orderBy('id', 'asc')
            ->paginate($paggLimit);
    }

    public function checkOptionExist($key = '', $locale = '')
    {
        return $this->model
            ->where('key', $key)
            ->where('locale', $locale)
            ->count();
    }

    public function getDefaultOptions()
    {
        return Config::get('cms.default_optionss');
    }

}