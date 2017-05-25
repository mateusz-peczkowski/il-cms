<?php

namespace App\Repositories\ModuleRecord;


use App\Repositories\Contracts\ModuleRecordRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class ModuleRecordCacheDecorator extends AbstractCacheDecorator implements ModuleRecordRepositoryInterface
{
    /**
     * @var object
     */
    protected $module_record;

    public function __construct(ModuleRecordRepositoryInterface $module_record, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $module_record);

        $this->module_record = $module_record;
        $this->cache->setTags($tags);
    }

    public function allByLang($locale = '')
    {
        $cacheName = 'module_records_all_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $module = $this->module_record->allByLang($locale);
        $this->cache->put($cacheName, $module, 60);

        return $module;
    }

    public function paginateByModule($order_records = 'created_at', $order_records_type = 'asc', $module_id = null, $locale = '', $paggLimit = 15)
    {
        $cacheName = 'module_records_paginate'.$module_id.'_'.$paggLimit.'_'.$order_records.'_'.$order_records_type.'_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $module = $this->module_record->paginateByModule($order_records, $order_records_type, $module_id, $locale, $paggLimit);
        $this->cache->put($cacheName, $module, 60);

        return $module;
    }


}