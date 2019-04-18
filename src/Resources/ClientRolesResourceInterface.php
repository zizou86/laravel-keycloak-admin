<?php

namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface ClientRolesResourceInterface
{
    public function create(?array $options = null): ClientRoleCreateResourceInterface;

    public function add(RoleRepresentationInterface $role);
}
