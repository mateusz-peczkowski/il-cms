<?php

namespace App\Repositories\Page;


use App\Repositories\Contracts\PageRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class PageCacheDecorator extends AbstractCacheDecorator implements PageRepositoryInterface
{
    /**
     * @var object
     */
    protected $page;

    public function __construct(PageRepositoryInterface $page, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $page);

        $this->page = $page;
        $this->cache->setTags($tags);
    }

    public function paginatedPages($locale = '', $paggLimit = 15)
    {
        $cacheName = 'pages_paginated_locale_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $pages = $this->page->paginatedPages($locale, $paggLimit);
        $this->cache->put($cacheName, $pages, 60);

        return $pages;
    }

    public function paginatedPagesTrash($paggLimit = 15)
    {
        $cacheName = 'pages_paginated_trash';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $pages = $this->page->paginatedPagesTrash($paggLimit);
        $this->cache->put($cacheName, $pages, 60);

        return $pages;
    }

    public function checkPageExist($tag = '', $locale = '')
    {
        $cacheName = 'page_' . $tag . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $exist = $this->page->checkPageExist($tag, $locale);
        $this->cache->put($cacheName, $exist, 60);

        return $exist;
    }

}