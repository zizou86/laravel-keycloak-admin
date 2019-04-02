<?php
namespace Keycloak\Admin\Resources;

use Keycloak\Admin\Representations\UserRepresentationInterface;

interface UserResourceInterface
{
    public function toRepresentation(): UserRepresentationInterface;
    /**
     * @return RoleMappingResourceInterface
     */
    public function roles();

    public function update(?array $options = null): UserUpdateResourceInterface;
}
