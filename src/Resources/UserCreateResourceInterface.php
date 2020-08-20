<?php

namespace Scito\Keycloak\Admin\Resources;

interface UserCreateResourceInterface
{
    public function username(string $username): UserCreateResourceInterface;

    public function email(string $email): UserCreateResourceInterface;

    public function enabled(bool $enabled): UserCreateResourceInterface;

    public function firstName(string $firstName): UserCreateResourceInterface;

    public function lastName(string $lastName): UserCreateResourceInterface;

    public function password(string $password): UserCreateResourceInterface;

    public function temporaryPassword(string $password): UserCreateResourceInterface;

    public function passwordIsTemporary(bool $temporary): UserCreateResourceInterface;

    public function emailVerified(bool $emailVerified): UserCreateResourceInterface;

    public function attributes(array $attributes): UserCreateResourceInterface;

    public function credentials(array $credentials): UserCreateResourceInterface;

    /**
     * @param array|null $actions
     * @return UserCreateResourceInterface
     */
    public function requiredActions(?array $actions): UserCreateResourceInterface;

    public function save(): UserResourceInterface;
}
