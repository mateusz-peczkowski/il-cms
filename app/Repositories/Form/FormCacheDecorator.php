<?php

namespace App\Repositories\Form;


use App\Repositories\Contracts\FormRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class FormCacheDecorator extends AbstractCacheDecorator implements FormRepositoryInterface
{
    /**
     * @var object
     */
    protected $form;

    public function __construct(FormRepositoryInterface $form, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $form);

        $this->form = $form;
        $this->cache->setTags($tags);
    }

    public function paginatedForms($locale = '', $paggLimit = 15)
    {
        $cacheName = 'forms_paginated_locale_'.$locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $forms = $this->form->paginatedForms($locale, $paggLimit);
        $this->cache->put($cacheName, $forms, 60);

        return $forms;
    }

    public function paginatedFormsTrash($paggLimit = 15)
    {
        $cacheName = 'forms_paginated_trash';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $forms = $this->form->paginatedFormsTrash($paggLimit);
        $this->cache->put($cacheName, $forms, 60);

        return $forms;
    }

    public function checkFormExist($tag = '', $locale = '')
    {
        $cacheName = 'form_' . $tag . '_' . $locale;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $exist = $this->form->checkFormExist($tag, $locale);
        $this->cache->put($cacheName, $exist, 60);

        return $exist;
    }
}