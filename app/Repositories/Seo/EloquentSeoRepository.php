<?php

namespace App\Repositories\Seo;

use App\Repositories\Contracts\SeoRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentSeoRepository extends AbstractRepository implements SeoRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Seo';
    }

    public function getByModel($model = '', $model_id = '')
    {
        $model = $this->model
            ->with('updater')
            ->where('model', $model)
            ->where('model_id', $model_id);
        return $model ? $model->first() : null;
    }

}