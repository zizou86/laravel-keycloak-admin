<?php
namespace Scito\Keycloak\Admin\Resources;

use Scito\Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Scito\Keycloak\Admin\Representations\RoleRepresentationInterface;

interface RolesResourceInterface
{
    /**
     * @return RepresentationCollectionInterface
     */
    public function list(): RepresentationCollectionInterface;

    public function add(RoleRepresentationInterface $role): void;

    public function create(?array $options = null): RoleCreateResourceInterface;

    public function update(RoleRepresentationInterface $role): void;

    /**
     * @param $name
     * @return mixed
     */
    public function get($name): RoleResourceInterface;

    /**
     * @param $name
     */
    public function delete($name): void;
}
