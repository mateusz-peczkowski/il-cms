<?php

namespace App\Repositories\Contracts;

interface SeoRepositoryInterface
{

    public function getByModel($model = '', $model_id = '');

}