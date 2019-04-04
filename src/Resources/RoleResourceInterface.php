<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface RoleResourceInterface
{
    /**
     * @return RoleRepresentationInterface
     */
    public function toRepresentation(): RoleRepresentationInterface;

    /**
     * Delete the current role
     */
    public function delete(): void;
    
    public function update(?array $options = null): RoleUpdateResourceInterface;
}
