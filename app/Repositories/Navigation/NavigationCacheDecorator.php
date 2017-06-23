<?php

namespace App\Repositories\Navigation;


use App\Repositories\Contracts\NavigationRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class NavigationCacheDecorator extends AbstractCacheDecorator implements NavigationRepositoryInterface
{
    /**
     * @var object
     */
    protected $navigation;

    public function __construct(NavigationRepositoryInterface $navigation, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $navigation);

        $this->navigation = $navigation;
        $this->cache->setTags($tags);
    }

    public function getActive()
    {
        $cacheName = 'navigations_get';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation->getActive();
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }

    public function paginatedNavigations($paggLimit = 15)
    {
        $cacheName = 'navigations_paginated_'.$paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation->paginatedNavigations($paggLimit);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }

    public function paginatedNavigationsTrash($paggLimit = 15)
    {
        $cacheName = 'navigations_paginated_trash_'.$paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation->paginatedNavigationsTrash($paggLimit);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }
}