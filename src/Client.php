<?php

namespace Scito\Keycloak\Admin;

use Scito\Keycloak\Admin\Exceptions\DefaultRealmMissingException;
use Scito\Keycloak\Admin\Resources\ClientsResourceInterface;
use Scito\Keycloak\Admin\Resources\ResourceFactoryInterface;
use Scito\Keycloak\Admin\Resources\RolesResourceInterface;
use Scito\Keycloak\Admin\Resources\UsersResourceInterface;

class Client
{
    private $defaultRealm;

    private $resourceFactory;

    public function __construct(
        ResourceFactoryInterface $resourceFactory,
        ?string $defaultRealm = null
    ) {
        $this->resourceFactory = $resourceFactory;
        $this->defaultRealm = $defaultRealm;
    }

    public function users(): UsersResourceInterface
    {
        return $this->resourceFactory->createUsersResource($this->checkDefaultRealm());
    }

    private function checkDefaultRealm()
    {
        if (null === $this->defaultRealm) {
            throw new DefaultRealmMissingException("The default realm is not set");
        }
        return $this->defaultRealm;
    }

    public function roles(): RolesResourceInterface
    {
        return $this->resourceFactory->createRolesResource($this->checkDefaultRealm());
    }

    public function clients(): ClientsResourceInterface
    {
        return $this->resourceFactory->createClientsResource($this->checkDefaultRealm());
    }

    public function realms()
    {
        return $this->resourceFactory
            ->createRealmsResource();
    }

    public function realm(string $realm)
    {
        return $this->resourceFactory
            ->createRealmResource($realm);
    }
}
