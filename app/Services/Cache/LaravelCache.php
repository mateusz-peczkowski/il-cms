<?php

namespace App\Services\Cache;

use App\Services\Contracts\CacheInterface;
use Illuminate\Cache\CacheManager;

class LaravelCache implements CacheInterface
{
    protected $cache;
    protected $cacheKey;
    protected $minutes;
    protected $tags;

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
     * Set tags for this Cache Store
     *
     * @param $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Set Cache Store tags if driver supports tagging
     * fallback to normal cache
     *
     * @param $tags
     * @return CacheManager
     */
    public function tags($tags)
    {
        if ($this->cache->driver()->getStore() instanceof \Illuminate\Cache\TaggableStore) {
            return $this->cache->tags($tags);
        }
        return $this->cache;
    }

    /**
     * Retrieve data from cache
     *
     * @param string Cache item key
     * @return mixed PHP data result of cache
     */
    public function get($key)
    {
        return $this->tags($this->tags)->get($key);
    }

    /**
     * Pull item from the cache and delete it
     *
     * @param  string  cache item key
     * @return mixed PHP results of cache
     */
    public function pull($key)
    {
        return $this->tags($this->tags)->pull($key);
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

        return $this->tags($this->tags)->put($key, $value, $minutes);
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
    public function putPaginated($items, $key, $minutes = null)
    {
        return $this->put($key, $items, $minutes);
    }

    /**
     * Store item in cache permanently
     *
     * @param string  Cache item key
     * @param mixed   The data to store
     */
    public function forever($key, $value)
    {
        return $this->tags($this->tags)->forever($key, $value);
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
        return $this->tags($this->tags)->has($key);
    }

    /**
     * Invalidate item in cache
     *
     * @param string  Cache item key
     * @return void
     */
    public function forget($key)
    {
        $this->tags($this->tags)->forget($key);
    }

    /**
     * Clear all items from the cache
     *
     * @return void
     */
    public function flush()
    {
        $this->tags($this->tags)->flush();
    }

}