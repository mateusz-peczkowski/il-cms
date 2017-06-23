<?php

namespace App\Repositories\Contracts;

interface SectionRepositoryInterface
{

	public function paginatedSections($locale = '', $paggLimit = 15);

	public function paginatedSectionsTrash($paggLimit = 15);

    public function checkSectionExist($tag = '', $locale = '');
}