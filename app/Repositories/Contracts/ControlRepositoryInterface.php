<?php

namespace App\Repositories\Contracts;

interface ControlRepositoryInterface
{

    public function getPaginatedByFormID($id = null, $paggLimit = 15);

}