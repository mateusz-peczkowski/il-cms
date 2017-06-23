<?php

namespace App\Repositories\NavigationNode;


use App\Repositories\Contracts\NavigationNodeRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class NavigationNodeCacheDecorator extends AbstractCacheDecorator implements NavigationNodeRepositoryInterface
{
    /**
     * @var object
     */
    protected $navigation_node;

    public function __construct(NavigationNodeRepositoryInterface $navigation_node, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $navigation_node);

        $this->navigation_node = $navigation_node;
        $this->cache->setTags($tags);
    }

    public function allByLang($locale = '')
    {
        $cacheName = 'navigation_nodes_all_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation_node->allByLang($locale);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }

    public function allByNavigation($navigation_id = null, $locale = '')
    {
        $cacheName = 'navigation_nodes_all'.$navigation_id.'_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation_node->allByNavigation($navigation_id, $locale);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }

    public function paginateByNavigation($navigation_id = null, $locale = '', $paggLimit = 15)
    {
        $cacheName = 'navigation_nodes_paginate'.$navigation_id.'_'.$paggLimit.'_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation_node->paginateByNavigation($navigation_id, $locale, $paggLimit);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }

    public function countByParentNav($navigation_id = null, $parent_id = null, $locale = '')
    {
        $cacheName = 'navigation_nodes_count'.$navigation_id.'_'.$parent_id.'_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $navigation = $this->navigation_node->countByParentNav($navigation_id, $parent_id, $locale);
        $this->cache->put($cacheName, $navigation, 60);

        return $navigation;
    }


}