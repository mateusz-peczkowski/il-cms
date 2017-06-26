<?php

namespace App\Repositories\Page;

use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentPageRepository extends AbstractRepository implements PageRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Page';
    }

    function paginatedPages($locale = '', $paggLimit = 15)
    {
    	return $this->model
            ->with('updater')
            ->where('locale', $locale)
            ->where('status', '<', 3)
            ->paginate($paggLimit);
    }

    function paginatedPagesTrash($paggLimit = 15)
    {
        return $this->model
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    function checkPageExist($tag = '', $locale = '')
    {
        return $this->model
            ->where('tag', $tag)
            ->where('locale', $locale)
            ->count();
    }

    function checkPageExistByURL($url = '', $locale = '')
    {
        return $this->model
            ->where('url', $url)
            ->where('locale', $locale)
            ->count();
    }

    function getPageSections($id)
    {
        return $this->model
            ->with('sections')
            ->find($id);
    }

    function getPageSectionsPaginated($id)
    {
        return $this->model
            ->find($id)
            ->sections()
            ->where('status', '<', 3)
            ->paginate();
    }

}