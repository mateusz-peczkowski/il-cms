<?php

namespace App\Repositories\Translation;

use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Services\Cache\Contracts\CacheInterface;

class TranslationCacheDecorator implements TranslationRepositoryInterface
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
        $this->translation = $translation;
        $this->cache = $cache;
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
}