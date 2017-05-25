<?php

namespace App\Repositories\ModuleRecord;

use App\Repositories\Contracts\ModuleRecordRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentModuleRecordRepository extends AbstractRepository implements ModuleRecordRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\ModuleRecord';
    }

    public function allByLang($locale = '')
    {
        return $this->model
            ->with('updater')
            ->where('locale', '=', $locale)
            ->orderBy('order', 'desc')
            ->get();
    }

    public function paginateByModule($order_records = 'created_at', $order_records_type = 'asc', $module_id = null, $locale = '', $paggLimit = 15)
    {
        return $this->model
            ->with('updater')
            ->where('module_id', '=', $module_id)
            ->where('locale', '=', $locale)
            ->orderBy($order_records, $order_records_type)
            ->paginate($paggLimit);
    }

}