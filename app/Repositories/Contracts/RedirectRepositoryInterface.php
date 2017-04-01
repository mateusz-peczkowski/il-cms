<?php

namespace App\Repositories\Contracts;

interface RedirectRepositoryInterface
{

    public function paginatedRedirects($paggLimit = 15);

    public function paginatedRedirectsTrash($paggLimit = 15);

    public function checkRedirectExist($from = false);

}