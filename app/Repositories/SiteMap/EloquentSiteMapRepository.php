<?php

namespace App\Repositories\SiteMap;

use App\Repositories\Contracts\SiteMapRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentSiteMapRepository extends AbstractRepository implements SiteMapRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\SiteMap';
    }

    public function paginatedRecords($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '<', 3)
            ->paginate($paggLimit);
    }

    public function paginatedRecordsTrash($paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('status', '=', 3)
            ->paginate($paggLimit);
    }

    public function checkRecordExistByUrl($key = '')
    {
        return $this->model
            ->where('url', $key)
            ->count();
    }

}