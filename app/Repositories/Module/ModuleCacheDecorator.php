<?php

namespace App\Repositories\Module;


use App\Repositories\Contracts\ModuleRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class ModuleCacheDecorator extends AbstractCacheDecorator implements ModuleRepositoryInterface
{
    /**
     * @var object
     */
    protected $module;

    public function __construct(ModuleRepositoryInterface $module, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $module);

        $this->module = $module;
        $this->cache->setTags($tags);
    }

    public function getActive()
    {
        $cacheName = 'modules_get';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $module = $this->module->getActive();
        $this->cache->put($cacheName, $module, 60);

        return $module;
    }

    public function paginatedModules($paggLimit = 15)
    {
        $cacheName = 'modules_paginated_'.$paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $module = $this->module->paginatedModules($paggLimit);
        $this->cache->put($cacheName, $module, 60);

        return $module;
    }

    public function paginatedModulesTrash($paggLimit = 15)
    {
        $cacheName = 'modules_paginated_trash_'.$paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $module = $this->module->paginatedModulesTrash($paggLimit);
        $this->cache->put($cacheName, $module, 60);

        return $module;
    }
}