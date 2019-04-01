<?php
namespace Keycloak\Admin\Representations;

interface RoleRepresentationBuilderInterface
{
    public function withName(string $name): RoleRepresentationBuilderInterface;

    public function withDescription(string $description): RoleRepresentationBuilderInterface;

    public function withClientRole(bool $isClientRole): RoleRepresentationBuilderInterface;

    public function withComposite(bool $composite): RoleRepresentationBuilderInterface;

    public function withContainerId(string $containerId): RoleRepresentationBuilderInterface;

    public function build(): RoleRepresentationInterface;
}
