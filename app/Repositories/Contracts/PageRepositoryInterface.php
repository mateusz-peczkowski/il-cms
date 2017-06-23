<?php

namespace App\Repositories\Contracts;

interface PageRepositoryInterface
{

	public function allActivePages($locale = '');

	public function paginatedPages($locale = '', $paggLimit = 15);

	public function paginatedPagesTrash($paggLimit = 15);

    public function checkPageExist($tag = '', $locale = '');

    public function checkPageExistByURL($url = '', $locale = '');

}