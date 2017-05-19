<?php

namespace App\Repositories\Contracts;

interface FormRepositoryInterface
{

    public function paginatedForms($locale = '', $paggLimit = 15);

    public function paginatedFormsTrash($paggLimit = 15);

    public function checkFormExist($tag = '', $locale = '');

}