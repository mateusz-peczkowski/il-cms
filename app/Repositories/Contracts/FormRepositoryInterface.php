<?php

namespace App\Repositories\Contracts;

interface FormRepositoryInterface
{

    public function paginatedForms($paggLimit = 15);

}