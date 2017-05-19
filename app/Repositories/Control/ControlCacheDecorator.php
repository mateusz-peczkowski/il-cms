<?php

namespace App\Repositories\Control;


use App\Repositories\Contracts\ControlRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class ControlCacheDecorator extends AbstractCacheDecorator implements ControlRepositoryInterface
{
    /**
     * @var object
     */
    protected $control;

    public function __construct(ControlRepositoryInterface $control, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $control);

        $this->control = $control;
        $this->cache->setTags($tags);
    }

    public function getPaginatedByFormID($id = null, $paggLimit = 15)
    {
        $cacheName = 'controls_paginated_by_form_id_' . $id;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $controls = $this->control->getPaginatedByFormID($id, $paggLimit);
        $this->cache->put($cacheName, $controls, 60);

        return $controls;
    }

}