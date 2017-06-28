<?php

namespace App\Repositories\Section;

use App\Repositories\Contracts\SectionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentSectionRepository extends AbstractRepository implements SectionRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Section';
    }

    function paginatedSections($locale = '', $paggLimit = 15)
    {
    	return $this->model
            ->with('updater')
            ->where('locale', $locale)
            ->where('status', '<', 3)
            ->paginate($paggLimit);
    }

    function paginatedSectionsTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkSectionExist($tag = '', $locale = '')
    {
        return $this->model
            ->where('tag', $tag)
            ->where('locale', $locale)
            ->count();
    }
}