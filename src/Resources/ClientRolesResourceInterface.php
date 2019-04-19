<?php

namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface ClientRolesResourceInterface
{
    public function all(): RepresentationCollectionInterface;

    public function create(?array $options = null): ClientRoleCreateResourceInterface;

    public function add(RoleRepresentationInterface $role);
}
