<?php
namespace Keycloak\Admin\Resources;

interface ClientsResourceInterface
{
    /**
     * @param string $id
     * @return ClientResourceInterface
     */
    public function get(string $id): ClientResourceInterface;

    public function create(ClientRepresentationInterface $client): void;

    /**
     * @return ClientRepresentationInterface[]
     */
    public function all(): array;
}
