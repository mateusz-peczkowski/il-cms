<?php

namespace App\Repositories\LoginAttempts;

use App\Repositories\Contracts\LoginAttemptsRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class EloquentLoginAttemptsRepository extends AbstractRepository implements LoginAttemptsRepositoryInterface
{

    /*
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\LoginAttempts';
    }
}