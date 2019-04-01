<?php
namespace Keycloak\Admin\Resources;

use Keycloak\Admin\Representations\UserRepresentation;
use Keycloak\Admin\Representations\UserRepresentationInterface;

interface UsersResourceInterface
{
    /**
     * @param $id
     * @return UserResourceInterface
     */
    public function get($id);

    public function getByEmail(string $email): ?UserRepresentationInterface;

    public function getByUsername(string $username): ?UserRepresentationInterface;

    public function add(UserRepresentationInterface $user): void;

    public function update(UserRepresentationInterface $user): void;

    /**
     * @return UsersSearchResourceInterface
     */
    public function search(): UsersSearchResourceInterface;

    public function create(?array $options = null): UserCreateResourceInterface;
}
