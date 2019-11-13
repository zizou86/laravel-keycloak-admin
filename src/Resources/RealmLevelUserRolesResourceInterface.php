<?php

namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface RealmLevelUserRolesResourceInterface
{
    public function add(RoleRepresentationInterface $role);

    /*
    public function remove(RoleRepresentationInterface $role);

    public function available();
    */
}
