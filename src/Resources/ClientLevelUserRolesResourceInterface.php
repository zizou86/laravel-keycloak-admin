<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface ClientLevelUserRolesResourceInterface
{
    public function all(): RepresentationCollectionInterface;

    public function add(RoleRepresentationInterface $role);

    public function delete(RoleRepresentationInterface $role);
}
