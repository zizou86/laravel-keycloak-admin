<?php
namespace Keycloak\Admin\Resources;

use IteratorAggregate;
use Keycloak\Admin\Representations\RepresentationCollection;
use Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Keycloak\Admin\Representations\UserRepresentationInterface;

interface UsersSearchResourceInterface extends IteratorAggregate
{
    public function offset(int $offset): UsersSearchResourceInterface;

    public function limit(int $limit): UsersSearchResourceInterface;

    public function lastName(string $lastName): UsersSearchResourceInterface;

    public function firstName(string $firstName): UsersSearchResourceInterface;

    public function email(string $email): UsersSearchResourceInterface;

    public function username(string $username): UsersSearchResourceInterface;

    public function briefRepresentation(bool $briefRepresentation): UsersSearchResourceInterface;

    public function query(string $query): UsersSearchResourceInterface;
    /**
     * @return RepresentationCollectionInterface<UserRepresentationInterface>
     */
    public function get();
    /**
     * @return UserRepresentationInterface|null
     */
    public function first();
}
