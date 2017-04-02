<?php

namespace App\Repositories\Contracts;

interface TranslationRepositoryInterface
{

    public function paginatedTranslations($locale = '', $paggLimit = 15);

    public function paginatedTranslationsTrash($paggLimit = 15);

    public function checkTranslationExist($key = false, $locale = '');

}