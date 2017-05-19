<?php

namespace App\Repositories\Role;


use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\Cache\AbstractCacheDecorator;
use App\Services\Contracts\CacheInterface;

class RoleCacheDecorator extends AbstractCacheDecorator implements RoleRepositoryInterface
{
    /**
     * @var object
     */
    protected $role;

    public function __construct(RoleRepositoryInterface $role, array $tags, CacheInterface $cache)
    {
        parent::__construct($cache, $role);

        $this->role = $role;
        $this->cache->setTags($tags);
    }

    public function listAllRoles()
    {
        $cacheName = 'roles_all';
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }

        $roles = $this->role->listAllRoles();
        $this->cache->forever($cacheName, $roles);

        return $roles;
    }
}