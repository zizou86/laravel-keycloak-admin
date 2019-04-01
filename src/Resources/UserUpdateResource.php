<?php
namespace Keycloak\Admin\Resources;

use GuzzleHttp\ClientInterface;

class UserUpdateResource implements UserUpdateResourceInterface
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var UserResourceInterface
     */
    private $userResource;
    /**
     * @var string
     */
    private $realm;
    /**
     * @var string
     */
    private $id;

    public function __construct(ClientInterface $client, UserResourceInterface $userResource, string $realm, string $id)
    {
        $this->client = $client;
        $this->userResource = $userResource;
        $this->realm = $realm;
        $this->id = $id;
    }

    public function username(?string $username): UserUpdateResourceInterface
    {
        // TODO: Implement username() method.
    }

    public function password(?string $password): UserUpdateResourceInterface
    {
        // TODO: Implement password() method.
    }

    public function enabled(?bool $enabled): UserUpdateResourceInterface
    {
        // TODO: Implement enabled() method.
    }

    public function save(): void
    {
        // TODO: Implement save() method.
    }
}
