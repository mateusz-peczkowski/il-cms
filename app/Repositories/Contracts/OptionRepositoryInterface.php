<?php

namespace App\Repositories\Contracts;

interface OptionRepositoryInterface
{

    public function getByType($type = '', $locale = '');

    public function getByTypePaginated($type = '', $locale = '', $paggLimit = 15);

    public function checkOptionExist($key = '', $locale = '');

}