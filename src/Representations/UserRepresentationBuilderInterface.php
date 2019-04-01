<?php
namespace Keycloak\Admin\Representations;

interface UserRepresentationBuilderInterface
{
    public function withUsername(string $username): UserRepresentationBuilderInterface;

    public function withEmail(string $email): UserRepresentationBuilderInterface;

    public function withPassword(string $password): UserRepresentationBuilderInterface;

    public function withEnabled(bool $enabled): UserRepresentationBuilderInterface;

    public function build(): UserRepresentationInterface;
}
