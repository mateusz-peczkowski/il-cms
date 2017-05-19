<?php

namespace App\Repositories\Language;

use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class LanguageCacheDecorator extends AbstractCacheDecorator implements LanguageRepositoryInterface
{
    /**
     * @var translation
     */
    protected $language;

    /**
     * Constructor
     *
     * @param
     */
    public function __construct(LanguageRepositoryInterface $language, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $language);
        $this->language = $language;

        $this->cache->setTags($tags);
    }

    public function allLanguagesCount()
    {
        $cacheName = 'language_count_all';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->allLanguagesCount();
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function checkLanguageExist($slug = false)
    {
        $cacheName = 'language_exist_' . $slug;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->checkLanguageExist($slug);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function paginatedLanguages($paggLimit = 15)
    {
        $cacheName = 'languages_paginated';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->paginatedLanguages($paggLimit);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function paginatedLanguagesTrash($paggLimit = 15)
    {
        $cacheName = 'language_pag_trash_' . $paggLimit;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->paginatedLanguagesTrash($paggLimit);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function isLocale($locale = '')
    {
        $cacheName = 'language_is_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->isLocale($locale);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function getDefaultLocale()
    {
        $cacheName = 'language_default_locale';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->getDefaultLocale();
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function getMoreDefaultLocales()
    {
        $cacheName = 'language_more_default_locales';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->getMoreDefaultLocales();
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function getMoreLocales()
    {
        $cacheName = 'language_more_locales';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->getMoreLocales();
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function getLocalesExcept($locale = '')
    {
        $cacheName = 'language_locales_except_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->getLocalesExcept($locale);
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function isMoreLocales()
    {
        $cacheName = 'language_is_more_locales';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $translations = $this->language->isMoreLocales();
        $this->cache->put($cacheName, $translations, 60);

        return $translations;
    }

    public function updater()
    {
        return false;
    }
}