<?php

namespace App\Repositories\NavigationNode;

use App\Repositories\Contracts\NavigationNodeRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentNavigationNodeRepository extends AbstractRepository implements NavigationNodeRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\NavigationNode';
    }

    public function allByLang($locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('locale', '=', $locale)
            ->orderBy('order', 'desc')
            ->get();
    }

    public function allByNavigation($navigation_id = null, $locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('navigation_id', '=', $navigation_id)
            ->where('locale', '=', $locale)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function paginateByNavigation($navigation_id = null, $locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('navigation_id', '=', $navigation_id)
            ->where('locale', '=', $locale)
            ->orderBy('order', 'asc')
            ->paginate($paggLimit);
    }

    public function countByParentNav($navigation_id = null, $parent_id = null, $locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('navigation_id', '=', $navigation_id)
            ->where('parent_id', '=', $parent_id)
            ->where('locale', '=', $locale)
            ->orderBy('order', 'desc')
            ->first();
    }

}