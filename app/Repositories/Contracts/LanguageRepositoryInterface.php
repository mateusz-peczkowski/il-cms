<?php

namespace App\Repositories\Contracts;

interface LanguageRepositoryInterface
{

    public function allLanguagesCount();

    public function paginatedLanguages($paggLimit = 15);

    public function paginatedLanguagesTrash($paggLimit = 15);

    public function checkLanguageExist($slug = false);

    public function isLocale($locale = '');

    public function getDefaultLocale();

    public function getMoreDefaultLocales();

    public function getMoreLocales();

    public function getLocalesExcept($locale = '');

    public function isMoreLocales();

}