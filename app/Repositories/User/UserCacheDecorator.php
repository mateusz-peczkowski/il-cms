<?php

namespace App\Repositories\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Cache\Contracts\CacheInterface;

class UserCacheDecorator extends AbstractCacheDecorator implements UserRepositoryInterface
{
    /**
     * @var user
     */
    protected $user;

    public function __construct(UserRepositoryInterface $user, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $user);

        $this->user = $user;
        $this->cache->setTags($tags);
    }

    public function allUsersCount()
    {
        $cacheName = 'users_count_all';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $count = $this->user->allUsersCount();
        $this->cache->put($cacheName, $count, 60);

        return $count;
    }

    public function checkUserEmailExist($email = false)
    {
        $cacheName = 'user_email_exist_' . $email;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $user = $this->user->checkUserEmailExist($email);
        $this->cache->put($cacheName, $user, 60);

        return $user;
    }

    public function paginatedUsers($paggLimit = 15)
    {
        $cacheName = 'users_paginated';

        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $users = $this->user->paginatedUsers($paggLimit);
        $this->cache->put($cacheName, $users, 60);

        return $users;
    }

    public function paginatedUsersTrash($paggLimit = 15)
    {
        $cacheName = 'users_paginated_trash';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $users = $this->user->paginatedUsersTrash($paggLimit);
        $this->cache->put($cacheName, $users, 60);

        return $users;
    }
}