<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface ClientRoleCreateResourceInterface
{
    public function name(string $name): ClientRoleCreateResourceInterface;

    public function description(string $description): ClientRoleCreateResourceInterface;

    public function save(): ClientRoleResourceInterface;
}
