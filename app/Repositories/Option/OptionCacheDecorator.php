<?php

namespace App\Repositories\Option;


use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Cache\Contracts\CacheInterface;

class OptionCacheDecorator extends AbstractCacheDecorator implements OptionRepositoryInterface
{
    /**
     * @var object
     */
    protected $option;

    public function __construct(OptionRepositoryInterface $option, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $option);

        $this->option = $option;
        $this->cache->setTags($tags);
    }

    public function checkOptionExist($key = '', $locale = '')
    {
        $cacheName = 'option_' . $key . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $exist = $this->option->checkOptionExist($key, $locale);
        $this->cache->put($cacheName, $exist, 60);

        return $exist;
    }

    public function getByType($type = '', $locale = '')
    {
        $cacheName = 'option_type_' . $type . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $options = $this->option->getByType($type, $locale);
        $this->cache->put($cacheName, $options, 60);

        return $options;
    }

    public function getByTypePaginated($type = '', $locale = '', $paggLimit = 15)
    {
        $cacheName = 'option_type_paginated_' . $type . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $options = $this->option->getByTypePaginated($type, $locale, $paggLimit);
        $this->cache->put($cacheName, $options, 60);

        return $options;
    }
}