<?php
namespace Keycloak\Admin\Resources;

use GuzzleHttp\ClientInterface;
use Keycloak\Admin\Hydrator\HydratorInterface;
use Keycloak\Admin\Representations\RealmRepresentationBuilder;
use Keycloak\Admin\Representations\RoleRepresentationBuilder;
use Keycloak\Admin\Representations\UserRepresentationBuilder;

class ResourceFactory implements ResourceFactoryInterface
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    public function __construct(ClientInterface $client, HydratorInterface $hydrator)
    {
        $this->client = $client;
        $this->hydrator = $hydrator;
    }

    public function createRealmsResource(): RealmsResourceInterface
    {
        return new RealmsResource($this->client, $this, $this->hydrator);
    }

    public function createRealmCreateResource(): RealmCreateResourceInterface
    {
        return new RealmCreateResource($this->createRealmsResource(), new RealmRepresentationBuilder());
    }

    public function createUsersResource(string $realm): UsersResourceInterface
    {
        return new UsersResource($this->client, $this, $this->hydrator, $realm);
    }

    public function createUserResource(string $realm, string $id): UserResourceInterface
    {
        return new UserResource($this->client, $this->hydrator, $realm, $id);
    }

    public function createRolesResource(string $realm): RolesResourceInterface
    {
        return new RolesResource($this->client, $this, $this->hydrator, $realm);
    }

    public function createRealmResource(string $realm): RealmResourceInterface
    {
        return new RealmResource($this->client, $this, $this->hydrator, $realm);
    }

    public function createClientsResource(string $realm): ClientsResourceInterface
    {
        return new ClientsResource();
    }

    public function createUsersSearchResource(string $realm): UsersSearchResourceInterface
    {
        return new UsersSearchResource($this->client, $this, $this->hydrator, $realm);
    }

    public function createUsersCreateResource(string $realm): UserCreateResourceInterface
    {
        $usersResource = $this->createUsersResource($realm);
        return new UserCreateResource($usersResource, new UserRepresentationBuilder());
    }

    public function createRoleResource(string $realm, string $role)
    {
        return new RoleResource($this->client, $this, $this->hydrator, $realm, $role);
    }

    public function createRolesCreateResource(string $realm): RoleCreateResourceInterface
    {
        return new RoleCreateResource(
            $this->createRolesResource($realm),
            new RoleRepresentationBuilder(),
            $realm
        );
    }

    public function createRoleUpdateResource(string $realm, string $role): RoleUpdateResourceInterface
    {
        return new RoleUpdateResource(
            $this->createRolesResource($realm),
            new RoleRepresentationBuilder(),
            $realm,
            $role
        );
    }
}
