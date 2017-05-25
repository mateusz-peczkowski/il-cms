<?php

namespace App\Observers;

use App\ModuleRecord;

class ModuleRecordObserver
{

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function created(ModuleRecord $module_record)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRecordRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function updated(ModuleRecord $module_record)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRecordRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function saved(ModuleRecord $module_record)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRecordRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function deleted(ModuleRecord $module_record)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRecordRepositoryInterface');
        return $cache->flush();
    }

    /**
     * Listen to the Language created event
     *
     * @param User
     * @return void
     */
    public function restored(ModuleRecord $module_record)
    {
        $cache = resolve('App\Repositories\Contracts\ModuleRecordRepositoryInterface');
        return $cache->flush();
    }

}