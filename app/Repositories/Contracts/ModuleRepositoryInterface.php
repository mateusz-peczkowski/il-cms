<?php

namespace App\Repositories\Contracts;

interface ModuleRepositoryInterface
{

    public function paginatedModules($paggLimit = 15);

    public function paginatedModulesTrash($paggLimit = 15);

}