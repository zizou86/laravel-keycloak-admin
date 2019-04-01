<?php
namespace Keycloak\Admin;

use Keycloak\Admin\Resources\ResourceFactoryInterface;

class Client
{
    public function __construct(
        ResourceFactoryInterface $resourceFactory
    ) {
        $this->resourceFactory = $resourceFactory;
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
