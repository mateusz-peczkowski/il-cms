<?php

namespace App\Services\Cache;

use App\Services\Cache\Contracts\CacheInterface;
use Illuminate\Cache\CacheManager;

class LaravelCache implements CacheInterface
{
    protected $cache;
    protected $cacheKey;
    protected $minutes;

    /**
     * Cache constructor
     */
    public function __construct(CacheManager $cache, $cacheKey = null, $minutes = null)
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->minutes = $minutes;
    }

    /**
     * Retrieve data from cache
     *
     * @param string Cache item key
     * @return mixed PHP data result of cache
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * Pull item from the cache and delete it
     *
     * @param  string  cache item key
     * @return mixed PHP results of cache
     */
    public function pull($key)
    {
        return $this->cache->pull($key);
    }

    /**
     * Add data to the cache
     *
     * @param string   Cache item key
     * @param mixed 	  The data to store
     * @param integer  Cache item lifetime in minutes
     * @return mixed   $value variable returned for convenience
     */
    public function put($key, $value, $minutes = null)
    {
        if( is_null($minutes) )
        {
            $minutes = $this->minutes;
        }

        return $this->cache->put($key, $value, $minutes);
    }

    /**
     * Add data to the cache
     * taking pagination into account
     *
     * @param integer  Page of the cached items
     * @param integer  Number of results per page
     * @param integer  Total number of possible items
     * @param mixed    The actual items for this page
     * @param string   Cache item key
     * @param integer  Cache item lifetime in minutes
     * @return mixed   $items variable returned for convenience
     */
    public function putPaginated($currentPage, $perPage, $totalItems, $items, $key, $minutes = null)
    {
        $cached = new \StdClass;

        $cached->currentPage = $currentPage;
        $cached->items = $items;
        $cached->totalItems = $totalItems;
        $cached->perPage = $perPage;

        $this->put($key, $cached, $minutes);

        return $cached;
    }

    /**
     * Store item in cache permanently
     *
     * @param string  Cache item key
     * @param mixed   The data to store
     */
    public function forever($key, $value)
    {
        return $this->cache->forever($key, $value);
    }

    /**
     * Test if item exists in cache
     * Only returns true if exists && is not expired
     *
     * @param string  Cache item key
     * @return bool   If cache item exists
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }

    /**
     * Invalidate item in cache
     *
     * @param string  Cache item key
     * @return void
     */
    public function forget($key)
    {
        $this->cache->forget($key);
    }

    /**
     * Clear all items from the cache
     *
     * @return void
     */
    public function flush()
    {
        $this->cache->flush();
    }

}