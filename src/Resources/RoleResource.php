<?php
namespace Scito\Keycloak\Admin\Resources;

use GuzzleHttp\ClientInterface;
use function json_decode;
use Scito\Keycloak\Admin\Exceptions\CannotDeleteRoleException;
use Scito\Keycloak\Admin\Exceptions\CannotRetrieveRoleRepresentationException;
use Scito\Keycloak\Admin\Hydrator\HydratorInterface;
use Scito\Keycloak\Admin\Representations\RoleRepresentation;
use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

class RoleResource implements RoleResourceInterface
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var ResourceFactoryInterface
     */
    private $resourceFactory;
    /**
     * @var string
     */
    private $realm;
    /**
     * @var string
     */
    private $role;
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    public function __construct(
        ClientInterface $client,
        ResourceFactoryInterface $resourceFactory,
        HydratorInterface $hydrator,
        string $realm,
        string $role
    ) {
        $this->client = $client;
        $this->resourceFactory = $resourceFactory;
        $this->realm = $realm;
        $this->role = $role;
        $this->hydrator = $hydrator;
    }

    public function toRepresentation(): RoleRepresentationInterface
    {
        $response = $this->client->get("/auth/admin/realms/{$this->realm}/roles/{$this->role}");

        if (200 !== $response->getStatusCode()) {
            throw new CannotRetrieveRoleRepresentationException("Unable to retrieve [$this->role] role details");
        }

        $data = json_decode((string)$response->getBody(), true);
        
        return $this->hydrator->hydrate($data, RoleRepresentation::class);
    }

    public function delete(): void
    {
        $response = $this->client->delete("/auth/admin/realms/{$this->realm}/roles/{$this->role}");

        if (204 !== $response->getStatusCode()) {
            throw new CannotDeleteRoleException("Role {$this->role} cannot be deleted");
        }
    }

    public function update(?array $options = []): RoleUpdateResourceInterface
    {
        $updateResource = $this->resourceFactory->createRoleUpdateResource($this->realm, $this->role);
        if (null !== $options) {
            foreach ($options as $key => $value) {
                $updateResource->$key($value);
            }
        }
        return $updateResource;
    }
}
