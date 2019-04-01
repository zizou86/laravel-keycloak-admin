<?php
namespace Keycloak\Admin\Resources;

use Keycloak\Admin\Representations\RoleRepresentationInterface;

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
