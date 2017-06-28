<?php

namespace App\Repositories\Translation;

use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class TranslationCacheDecorator extends AbstractCacheDecorator implements TranslationRepositoryInterface
{

    /**
     * @var cache
     */
    protected $cache;

    /**
     * @var translation
     */
    protected $translation;

    /**
     * Constructor
     *
     * @param
     */
    public function __construct(TranslationRepositoryInterface $translation, array $tags,  CacheInterface $cache)
    {
        parent::__construct($cache, $translation);

        $this->translation = $translation;
        $this->cache->setTags($tags);
    }

    public function checkTranslationExist($key = false, $locale = '')
    {
        $cacheName = 'translation_' . $key . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translation = $this->translation->checkTranslationExist($key, $locale);
        $this->cache->put($cacheName, $translation, 60);

        return $translation;
    }

    public function paginatedTranslations($locale = '', $paggLimit = 15)
    {
        $cacheName = 'translation_paginated_' . $locale . '_' . $paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->translation->paginatedTranslations($locale, $paggLimit);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function paginatedTranslationsTrash($paggLimit = 15)
    {
        $cacheName = 'translation_paginated_trash_' . $paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->translation->paginatedTranslationsTrash($paggLimit);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function findByKey($key = false, $locale = '')
    {
        $cacheName = 'translation_by_key_' . $key . '_locale_' . $locale;
        if ($this->cache->has($cacheName)) {
            return$this->cache->get($cacheName);
        }

        $translation = $this->translation->findByKey($key, $locale);
        $this->cache->put($cacheName, $translation, 60);

        return $translation;
    }
}