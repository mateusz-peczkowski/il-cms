<?php

namespace App\Repositories\Language;

use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentLanguageRepository extends AbstractRepository implements LanguageRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Language';
    }

    public function allLanguagesCount()
    {
        return $this->model->count();
    }

    function paginatedLanguages($paggLimit = 15)
    {
        return $this->model
            ->where('status', '<', 3)
            ->orderBy('order', 'asc')
            ->paginate($paggLimit);
    }

    function paginatedLanguagesTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkLanguageExist($slug = false)
    {
        return $this->model
            ->where('slug', '=', $slug)
            ->count();
    }

}