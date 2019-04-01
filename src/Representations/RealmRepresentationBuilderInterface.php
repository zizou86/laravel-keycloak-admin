<?php
namespace Keycloak\Admin\Representations;

interface RealmRepresentationBuilderInterface
{
    public function withName(string $name): RealmRepresentationBuilderInterface;

    public function withEnabled(bool $enabled): RealmRepresentationBuilderInterface;

    public function withDisplayName(string $displayName): RealmRepresentationBuilderInterface;

    public function withAccessCodeLifespan(int $accessCodeLifespan): RealmRepresentationBuilderInterface;

    public function withAccessCodeLifespanLogin(int $accessCodeLifespanLogin): RealmRepresentationBuilderInterface;

    public function withAccessCodeLifespanUserAction(int $accessCodeLifespanUserAction): RealmRepresentationBuilderInterface;

    public function withAccessTokenLifespan(int $accessTokenLifespan): RealmRepresentationBuilderInterface;

    public function withAccessTokenLifespanForImplicitFlow(int $accessTokenLifespanForImplicitFlow): RealmRepresentationBuilderInterface;

    public function withAccountTheme(string $accountTheme): RealmRepresentationBuilderInterface;

    public function withActionTokenGeneratedByAdminLifespan(int $actionTokenGeneratedByAdminLifespan): RealmRepresentationBuilderInterface;

    public function withActionTokenGeneratedByUserLifespan(int $actionTokenGeneratedByUserLifespan): RealmRepresentationBuilderInterface;

    public function withAdminEventsDetailsEnabled(bool $adminEventsDetailsEnabled): RealmRepresentationBuilderInterface;

    public function withAdminEventsEnabled(bool $adminEventsEnabled): RealmRepresentationBuilderInterface;

    public function withAdminTheme(string $adminTheme): RealmRepresentationBuilderInterface;

    public function withAttributes(?array $attributes): RealmRepresentationBuilderInterface;

    public function withBruteForceProtected(bool $bruteForceProtected): RealmRepresentationBuilderInterface;

    public function withRememberMe(bool $rememberMe): RealmRepresentationBuilderInterface;

    public function withRoles($roles): RealmRepresentationBuilderInterface;

    public function build(): RealmRepresentationInterface;
}