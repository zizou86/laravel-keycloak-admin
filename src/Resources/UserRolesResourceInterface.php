<?php

namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RepresentationCollectionInterface;

interface UserRolesResourceInterface
{
    public function all(): RepresentationCollectionInterface;

    public function realm(): RealmLevelUserRolesResourceInterface;

    public function client(string $id): ClientLevelUserRolesResourceInterface;
}
