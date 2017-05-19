<?php

namespace App\Services\Cache\Contracts;

interface CacheInterface
{
    public function setTags($tags);

    public function tags($tags);

    /**
     * Retrieve data from cache
     *
     * @param string cache item key
     * @return mixed PHP data result of cache
     */
    public function get($key);

    /**
     * Pull item from the cache and delete it
     *
     * @param  string  Cache item key
     * @return mixed PHP results of cache
     */
    public function pull($key);

    /**
     * Add data to the cache
     *
     * @param string   Cache item key
     * @param mixed 	  The data to store
     * @param integer  Cache item lifetime in minutes
     * @return mixed   $value variable returned for convenience
     */
    public function put($key, $value, $minutes = null);

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
    public function putPaginated($items, $key, $minutes = null);

    /**
     * Store item in cache permanently
     *
     * @param string  Cache item key
     * @param mixed   The data to store
     */
    public function forever($key, $value);

    /**
     * Test if item exists in cache
     * Only returns true if exists && is not expired
     *
     * @param string  Cache item key
     * @return bool   If cache item exists
     */
    public function has($key);

    /**
     * Invalidate item in cache
     *
     * @param string  Cache item key
     * @return void
     */
    public function forget($key);

    /**
     * Clear all items from the cache
     *
     * @return void
     */
    public function flush();
}