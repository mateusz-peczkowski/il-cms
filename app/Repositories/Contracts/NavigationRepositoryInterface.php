<?php

namespace App\Repositories\Contracts;

interface NavigationRepositoryInterface
{

    public function getActive();

    public function paginatedNavigations($paggLimit = 15);

    public function paginatedNavigationsTrash($paggLimit = 15);

}