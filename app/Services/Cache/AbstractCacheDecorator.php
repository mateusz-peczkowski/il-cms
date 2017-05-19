<?php

namespace App\Services\Cache;


use App\Services\Contracts\CacheInterface;

abstract class AbstractCacheDecorator
{
    /**
     * @var cache
     */
    protected $cache;

    public function __construct(CacheInterface $cache, $repository)
    {
        $this->cache = $cache;
        $this->repository = $repository;
    }

    public function flush()
    {
        $this->cache->flush();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }
}