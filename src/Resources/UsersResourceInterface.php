<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\UserRepresentationInterface;

interface UsersResourceInterface
{
    /**
     * @param $id
     * @return UserResourceInterface
     */
    public function get($id);

    public function getByEmail(string $email): ?UserRepresentationInterface;

    public function getByUsername(string $username): ?UserRepresentationInterface;

    public function add(UserRepresentationInterface $user): UserResourceInterface;

    public function update(UserRepresentationInterface $user): void;

    /**
     * @param array $options
     * @return UserSearchResourceInterface
     */
    public function search(?array $options = null): UserSearchResourceInterface;

    public function create(?array $options = null): UserCreateResourceInterface;
}
