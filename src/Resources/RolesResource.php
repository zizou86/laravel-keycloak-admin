<?php

namespace Keycloak\Admin\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use function json_encode;
use Keycloak\Admin\Exceptions\CannotCreateRoleException;
use Keycloak\Admin\Exceptions\CannotUpdateRoleException;
use Keycloak\Admin\Hydrator\HydratorInterface;
use Keycloak\Admin\Representations\RepresentationCollection;
use Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Keycloak\Admin\Representations\RoleRepresentation;
use Keycloak\Admin\Representations\RoleRepresentationInterface;

class RolesResource implements RolesResourceInterface
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $realm;
    /**
     * @var HydratorInterface
     */
    private $hydrator;
    /**
     * @var ResourceFactoryInterface
     */
    private $resourceFactory;

    public function __construct(
        ClientInterface $client,
        ResourceFactoryInterface $resourceFactory,
        HydratorInterface $hydrator,
        string $realm
    ) {
        $this->client = $client;
        $this->realm = $realm;
        $this->hydrator = $hydrator;
        $this->resourceFactory = $resourceFactory;
    }

    public function get($name): RoleResourceInterface
    {
        return $this->resourceFactory
            ->createRoleResource($this->realm, $name);
    }

    public function delete($name): void
    {
        $this
            ->get($name)
            ->delete();
    }

    /**
     * @return RepresentationCollectionInterface
     */
    public function list(): RepresentationCollectionInterface
    {
        $response = $this->client->get("/auth/admin/realms/{$this->realm}/roles");

        $json = (string)$response->getBody();
        $users = json_decode($json, true);

        $items = array_map(function ($role) {
            return $this->hydrator->hydrate($role, RoleRepresentation::class);
        }, $users);

        return new RepresentationCollection($items);
    }

    public function getByName($name)
    {
        $response = $this->get("/auth/{$this->realm}/roles/{$name}");
    }

    public function add(RoleRepresentationInterface $role): void
    {
        $data = $this->hydrator->extract($role);
        unset($data['id']);

        $response = $this->client->post("/auth/admin/realms/{$this->realm}/roles", [
            'body' => json_encode($data)
        ]);

        if (201 != $response->getStatusCode()) {
            throw new CannotCreateRoleException("Unable to create role");
        }
    }

    public function create(?array $options = null): RoleCreateResourceInterface
    {
        return $this->resourceFactory->createRolesCreateResource($this->realm);
    }

    public function update(RoleRepresentationInterface $role): void
    {
        $data = $this->hydrator->extract($role);
        $roleName = $data['name'];

        $response = $this->client->put("/auth/admin/realms/{$this->realm}/roles/{$roleName}", [
            'body' => json_encode($data)
        ]);

        if (204 != $response->getStatusCode()) {
            throw new CannotUpdateRoleException("Unable to update role $roleName");
        }
    }
}
