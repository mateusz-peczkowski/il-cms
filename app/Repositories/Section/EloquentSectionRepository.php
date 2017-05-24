<?php

namespace App\Repositories\Section;

use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Container\Container as App;

class EloquentSectionRepository extends AbstractRepository
{
    function model()
    {
        return 'App\Section';
    }

}