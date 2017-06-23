<?php

namespace App\Repositories\Contracts;

interface NavigationNodeRepositoryInterface
{

    public function allByLang($locale = '');

    public function allByNavigation($navigation_id = null, $locale = '');

    public function paginateByNavigation($navigation_id = null, $locale = '', $paggLimit = 15);

    public function countByParentNav($navigation_id = null, $parent_id = null, $locale = '');

}