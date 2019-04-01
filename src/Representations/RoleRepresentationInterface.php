<?php
namespace Keycloak\Admin\Representations;

interface RoleRepresentationInterface
{
    public function getId(): ?string;

    public function getName(): ?string;

    public function getDescription(): ?string;

    public function getContainerId(): ?string;

    public function isClientRole(): ?bool;

    public function isComposite(): ?bool;
}
