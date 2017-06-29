<?php

namespace App\Repositories\Contracts;

interface SiteMapRepositoryInterface
{
    public function paginatedRecords($paggLimit = 15);

    public function paginatedRecordsTrash($paggLimit = 15);

    public function checkRecordExistByUrl($key = '');
}