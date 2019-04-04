<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\UserRepresentationInterface;

interface UserResourceInterface
{
    public function toRepresentation(): UserRepresentationInterface;
    /**
     * @return RoleMappingResourceInterface
     */
    public function roles();

    public function update(?array $options = null): UserUpdateResourceInterface;
}
