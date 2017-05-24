<?php

namespace App\Repositories\Seo;


use App\Repositories\Contracts\SeoRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class SeoCacheDecorator extends AbstractCacheDecorator implements SeoRepositoryInterface
{
    /**
     * @var object
     */
    protected $seo;

    public function __construct(SeoRepositoryInterface $seo, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $seo);

        $this->seo = $seo;
        $this->cache->setTags($tags);
    }

    public function getByModel($model = '', $model_id = '')
    {
        $cacheName = 'seo_' . $model . '_' . $model_id;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $exist = $this->seo->getByModel($model, $model_id);
        $this->cache->put($cacheName, $exist, 60);

        return $exist;
    }

}