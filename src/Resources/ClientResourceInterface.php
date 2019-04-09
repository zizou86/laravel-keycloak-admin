<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\ClientRepresentationInterface;

interface ClientResourceInterface
{
    public function toRepresentation(): ClientRepresentationInterface;

    public function roles(): ClientRolesResourceInterface;

    public function getId(): string;

    public function getRealm(): string;
}
