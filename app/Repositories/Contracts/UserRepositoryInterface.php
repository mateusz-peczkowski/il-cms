<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function allUsersCount();

    public function paginatedUsers($paggLimit = 15);

    public function paginatedUsersTrash($paggLimit = 15);

    public function checkUserEmailExist($email = false);

    public function findByIdAndToken($identifier, $token);

    public function retrieveByCredentials(array $credentials);

    public function retrieveById($identifier);
}