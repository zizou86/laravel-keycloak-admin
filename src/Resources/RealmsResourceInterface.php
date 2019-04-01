<?php
namespace Keycloak\Admin\Resources;

use Keycloak\Admin\Representations\RealmRepresentationInterface;

interface RealmsResourceInterface
{
    /**
     * @param $realm
     * @return RealmResourceInterface
     */
    public function realm($realm): RealmResourceInterface;

    /**
     * @param RealmRepresentationInterface $realm
     */
    public function add(RealmRepresentationInterface $realm): void;

    public function create(?array $options = null): RealmCreateResourceInterface;

    /**
     * @return RealmRepresentationInterface[]
     */
    public function all(): array;
}
