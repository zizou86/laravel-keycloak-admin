<?php
namespace Keycloak\Admin\Resources;

interface UserCreateResourceInterface
{
    public function username(string $username): UserCreateResourceInterface;

    public function email(string $email): UserCreateResourceInterface;

    public function enabled(bool $enabled): UserCreateResourceInterface;

    public function password(string $password): UserCreateResourceInterface;

    public function temporaryPassword(string $password): UserCreateResourceInterface;

    public function passwordIsTemporary(bool $temporary): UserCreateResourceInterface;
    /**
     * @param array|null $actions
     * @return UserCreateResourceInterface
     */
    public function requiredActions(?array $actions): UserCreateResourceInterface;

    public function save(): void;
}
