<?php
namespace Keycloak\Admin\Resources;

interface ResourceFactoryInterface
{
    public function createRealmsResource(): RealmsResourceInterface;

    public function createRealmCreateResource(): RealmCreateResourceInterface;

    /**
     * @param string $realm
     * @return UsersResourceInterface
     */
    public function createUsersResource(string $realm): UsersResourceInterface;

    /**
     * @param string $realm
     * @param string $id
     * @return UserResourceInterface
     */
    public function createUserResource(string $realm, string $id): UserResourceInterface;

    /**
     * @param string $realm
     * @return RealmResourceInterface
     */
    public function createRealmResource(string $realm): RealmResourceInterface;

    /**
     * @param string $realm
     * @return ClientsResourceInterface
     */
    public function createClientsResource(string $realm): ClientsResourceInterface;

    /**
     * @param string $realm
     * @return UsersSearchResourceInterface
     */
    public function createUsersSearchResource(string $realm): UsersSearchResourceInterface;

    public function createUsersCreateResource(string $realm): UserCreateResourceInterface;

    /**
     * @param string $realm
     * @param string $role
     * @return RoleResourceInterface
     */
    public function createRoleResource(string $realm, string $role);

    /**
     * @param string $realm
     * @return RolesResourceInterface
     */
    public function createRolesResource(string $realm): RolesResourceInterface;
    /**
     * @param string $realm
     * @return RoleCreateResourceInterface
     */
    public function createRolesCreateResource(string $realm): RoleCreateResourceInterface;
    /**
     * @param string $realm
     * @param string $role
     * @return RoleUpdateResourceInterface
     */
    public function createRoleUpdateResource(string $realm, string $role): RoleUpdateResourceInterface;
}
