<?php
namespace Keycloak\Admin\Resources;

interface UserUpdateResourceInterface
{
    public function username(?string $username): UserUpdateResourceInterface;

    public function password(?string $password): UserUpdateResourceInterface;

    public function enabled(?bool $enabled): UserUpdateResourceInterface;

    public function save(): void;
}
