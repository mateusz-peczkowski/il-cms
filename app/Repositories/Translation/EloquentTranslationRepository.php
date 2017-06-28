<?php

namespace App\Repositories\Translation;

use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentTranslationRepository extends AbstractRepository implements TranslationRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Translation';
    }

    function paginatedTranslations($locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '<', 3)
            ->where('locale', $locale)
            ->orderBy('key', 'desc')
            ->paginate($paggLimit);
    }

    function paginatedTranslationsTrash($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkTranslationExist($key = false, $locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('key', '=', $key)
            ->where('locale', $locale)
            ->count();
    }

    public function findByKey($key = false, $locale = '')
    {
        return $this->model
            ->where('key', $key)
            ->where('locale', $locale)
            ->first();

    }
}