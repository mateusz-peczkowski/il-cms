<?php

namespace App\Observers;

use App\Language;

class LanguageObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Language $language)
    {
        $cache = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Language $language)
    {
        $cache = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Language $language)
    {
        $cache = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Language $language)
    {
        $cache = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Language $language)
    {
        $cache = resolve('App\Repositories\Contracts\LanguageRepositoryInterface');
        return $cache->flush();
    }

}