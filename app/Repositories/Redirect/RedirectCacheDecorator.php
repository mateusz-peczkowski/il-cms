<?php

namespace App\Repositories\Redirect;


use App\Repositories\Contracts\RedirectRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class RedirectCacheDecorator extends AbstractCacheDecorator implements RedirectRepositoryInterface
{
    /**
     * @var object
     */
    protected $redirect;

    public function __construct(RedirectRepositoryInterface $redirect, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $redirect);

        $this->redirect = $redirect;
        $this->cache->setTags($tags);
    }

    public function checkRedirectExist($from = false)
    {
        $cacheName = 'redirect_exist_' . $from;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $redirect = $this->redirect->checkRedirectExist($from);
        $this->cache->put($cacheName, $redirect, 60);

        return $redirect;
    }

    public function paginatedRedirects($paggLimit = 15)
    {
        $cacheName = 'redirects_paginated';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $redirects = $this->redirect->paginatedRedirects($paggLimit);
        $this->cache->put($cacheName, $redirects, 60);

        return $redirects;
    }

    public function paginatedRedirectsTrash($paggLimit = 15)
    {
        $cacheName = 'redirects_paginated_trash';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $redirects = $this->redirect->paginatedRedirectsTrash($paggLimit);
        $this->cache->put($cacheName, $redirects, 60);

        return $redirects;
    }
}