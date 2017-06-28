<?php

namespace App\Repositories\Section;

use App\Repositories\Contracts\SectionRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class SectionCacheDecorator extends AbstractCacheDecorator implements SectionRepositoryInterface
{
    /**
     * @var object
     */
    protected $section;

    public function __construct(SectionRepositoryInterface $section, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $section);

        $this->section = $section;
        $this->cache->setTags($tags);
    }

    public function paginatedSections($locale = '', $paggLimit = 15)
    {
        $cacheName = 'sections_paginated_locale_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $sections = $this->section->paginatedSections($locale, $paggLimit);
        $this->cache->put($cacheName, $sections, 60);

        return $sections;
    }

    public function paginatedSectionsTrash($paggLimit = 15)
    {
        $cacheName = 'sections_paginated_trash';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $sections = $this->section->paginatedSectionsTrash($paggLimit);
        $this->cache->put($cacheName, $sections, 60);

        return $sections;
    }

    public function checkSectionExist($tag = '', $locale = '')
    {
        $cacheName = 'section_' . $tag . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $exist = $this->section->checkSectionExist($tag, $locale);
        $this->cache->put($cacheName, $exist, 60);

        return $exist;
    }
}