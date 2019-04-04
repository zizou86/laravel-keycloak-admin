<?php
namespace Scito\Keycloak\Admin\Resources;

interface ClientsResourceInterface
{
    /**
     * @param string $id
     * @return ClientResourceInterface
     */
    public function get(string $id): ClientResourceInterface;

    public function add(ClientRepresentationInterface $client): void;

    public function create(): ClientCreateResourceInterface;

    /**
     * @return ClientRepresentationInterface[]
     */
    public function all(): array;
}
