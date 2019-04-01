<?php
namespace Keycloak\Admin\Representations;

interface UserRepresentationInterface extends RepresentationInterface
{
    public function getId(): ?string;
    public function getUsername(): ?string;
    public function getEmail(): ?string;
}
