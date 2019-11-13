<?php

namespace Scito\Keycloak\Admin\Resources;

use GuzzleHttp\ClientInterface;
use Scito\Keycloak\Admin\Exceptions\CannotAssignRoleException;
use Scito\Keycloak\Admin\Hydrator\HydratorInterface;
use Scito\Keycloak\Admin\Representations\RealmRepresentationBuilder;
use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

class RealmLevelUserRolesResource implements RealmLevelUserRolesResourceInterface
{
    /**
     * @var ResourceFactoryInterface
     */
    private $resourceFactory;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $realm;

    /**
     * @var string
     */
    private $userId;

    private $hydrator;

    public function __construct(
        ClientInterface $client,
        ResourceFactoryInterface $resourceFactory,
        HydratorInterface $hydrator,
        string $realm,
        string $userId
    ) {
        $this->resourceFactory = $resourceFactory;
        $this->hydrator = $hydrator;
        $this->client = $client;
        $this->realm = $realm;
        $this->userId = $userId;
    }

    public function add(RoleRepresentationInterface $role)
    {
        $role = $this->hydrator->extract($role);

        $response = $this->client->post("/auth/admin/realms/{$this->realm}/users/{$this->userId}/role-mappings/realm", ['body' => json_encode([$role])]);

        if (204 !== $response->getStatusCode()) {
            throw new CannotAssignRoleException();
        }
    }

    /*
    public function remove(RoleRepresentationInterface $role)
    {
        // TODO: Implement remove() method.
    }

    public function available()
    {
        // TODO: Implement available() method.
    }
    */
}
