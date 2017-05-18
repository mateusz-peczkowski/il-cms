<?php

namespace App\Services\Cache;


use App\Services\Cache\Contracts\CacheInterface;

abstract class AbstractCacheDecorator
{
    /**
     * @var cache
     */
    protected $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function flush()
    {
        $this->cache->flush();
    }

}