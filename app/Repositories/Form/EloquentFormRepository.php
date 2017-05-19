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

    function paginatedForms($locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('controls_active', 'controls', 'updater')
            ->where('locale', $locale)
            ->where('status', '<', 3)
            ->paginate($paggLimit);
    }

    function paginatedFormsTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkFormExist($tag = '', $locale = '')
    {
        return $this->model
            ->where('tag', $tag)
            ->where('locale', $locale)
            ->count();
    }

}