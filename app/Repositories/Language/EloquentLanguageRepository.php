<?php

namespace App\Repositories\Language;

use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;
use Session;

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
            ->with('updater')
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

    public function isLocale($locale = '')
    {
        return $this->model
            ->where('status', '1')
            ->where('slug', '=', $locale)
            ->count();
    }

    public function getDefaultLocale()
    {
        return $this->model
            ->where('status', '1')
            ->where('is_default', '=', '1')
            ->get();
    }

    public function getMoreDefaultLocales()
    {
        return $this->model
            ->where('status', '1')
            ->where('is_default', '!=', '1')
            ->get();
    }

    public function getMoreLocales()
    {
        return $this->model
            ->where('status', '1')
            ->where('slug', '!=', Session::get('cms_locale'))
            ->get();
    }

    public function getLocalesExcept($locale = '')
    {
        return $this->model
            ->where('status', '1')
            ->where('slug', '!=', $locale)
            ->get();
    }

    public function isMoreLocales()
    {
        return $this->model
            ->where('is_default', '!=', '1')
            ->where('status', '1')
            ->count();
    }

}