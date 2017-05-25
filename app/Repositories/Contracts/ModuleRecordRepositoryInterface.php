<?php

namespace App\Repositories\Contracts;

interface ModuleRecordRepositoryInterface
{

    public function allByLang($locale = '');

    public function paginateByModule($order_records = 'created_at', $order_records_type = 'asc', $module_id = null, $locale = '', $paggLimit = 15);

}