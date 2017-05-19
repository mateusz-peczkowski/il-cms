<?php

namespace App\Observers;

use App\Form;

class FormObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(Form $form)
    {
        $cache = resolve('App\Repositories\Contracts\FormRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(Form $form)
    {
        $cache = resolve('App\Repositories\Contracts\FormRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(Form $form)
    {
        $cache = resolve('App\Repositories\Contracts\FormRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(Form $form)
    {
        $cache = resolve('App\Repositories\Contracts\FormRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(Form $form)
    {
        $cache = resolve('App\Repositories\Contracts\FormRepositoryInterface');
        return $cache->flush();
    }

}