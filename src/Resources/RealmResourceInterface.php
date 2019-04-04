<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RealmRepresentationInterface;

interface RealmResourceInterface
{
    /**
     * @return RealmRepresentationInterface
     */
    public function toRepresentation(): RealmRepresentationInterface;

    public function update(?array $options = null): RealmUpdateResourceInterface;

    /**
     * @return ClientsResourceInterface
     */
    public function clients(): ClientsResourceInterface;

    /**
     * @return UsersResourceInterface
     */
    public function users(): UsersResourceInterface;

    /**
     * @return RolesResourceInterface
     */
    public function roles(): RolesResourceInterface;

    /**
     * @return GroupsResourceInterface
     */
    public function groups(): GroupsResourceInterface;

    public function delete(): void;
}
