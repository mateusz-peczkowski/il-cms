<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\CacheInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;


class CachedUserProvider implements UserProvider
{
    protected $hasher;
    protected $user;
    protected $cache;

    public function __construct(Hasher $hasher, UserRepositoryInterface $user, CacheInterface $cache, array $tags)
    {
        $this->user = $user;
        $this->hasher = $hasher;
        $this->cache = $cache;
        $this->cache->setTags($tags);
    }

    public function retrieveById($identifier)
    {
        return $this->user->retrieveById($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->user->findByIdAndToken($identifier, $token);
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->user->retrieveByCredentials($credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}