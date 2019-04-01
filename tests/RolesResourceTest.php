<?php
namespace Keycloak\Admin\Tests;

use Keycloak\Admin\Exceptions\CannotDeleteRoleException;
use Keycloak\Admin\Representations\RoleRepresentationBuilder;
use Keycloak\Admin\Representations\RoleRepresentationBuilderInterface;
use Keycloak\Admin\Representations\RoleRepresentationInterface;
use Keycloak\Admin\Resources\RolesResourceInterface;
use Keycloak\Admin\Tests\Traits\WithFaker;
use Keycloak\Admin\Tests\Traits\WithTestClient;

class RolesResourceTest extends TestCase
{
    use WithFaker, WithTestClient;

    /**
     * @var RolesResourceInterface
     */
    private $resource;
    /**
     * @var RoleRepresentationBuilderInterface
     */
    private $builder;

    public function setUp(): void
    {
        parent::setUp();
        $this->builder = new RoleRepresentationBuilder();
        $this->resource = $this->client->realm('master')->roles();
    }

    /**
     * @test
     */
    public function role_details_can_be_retrieved()
    {
        $role = $this
            ->resource
            ->get('admin')
            ->toRepresentation();

        $this->assertInstanceOf(RoleRepresentationInterface::class, $role);
        $this->assertNotEmpty($role->getDescription());
    }

    /**
     * @test
     */
    public function roles_can_be_retrieved()
    {
        $roles = $this->resource->list();

        $this->assertGreaterThan(1, count($roles));

        /* @var RoleRepresentationInterface $adminRole */
        $adminRole = $roles->first(function(RoleRepresentationInterface $role) {
            return 'admin' == $role->getName();
        }, false);

        $this->assertInstanceOf(RoleRepresentationInterface::class, $adminRole);
        $this->assertEquals('${role_admin}', $adminRole->getDescription());
        $matches = filter_var(preg_match('/^([a-z0-9\-]){36}$/', $adminRole->getId()), FILTER_VALIDATE_BOOLEAN);
        $this->assertTrue($matches);
    }

    private function roleExists($roleName)
    {
        $roles = $this->resource->list();

        $role = $roles->first(function(RoleRepresentationInterface $role) use ($roleName) {
            return $roleName == $role->getName();
        });

        return $role instanceof RoleRepresentationInterface;
    }

    /**
     * @depends roles_can_be_retrieved
     * @test
     */
    public function roles_can_be_created() {
        $roleName = $this->faker->slug;

        $this->resource->add(
            $this->builder
                ->withName($roleName)
                ->build()
        );
        $this->assertTrue($this->roleExists($roleName));
    }

    /**
     * @test
     */
    public function an_exception_gets_thrown_when_the_role_cannot_be_deleted()
    {
        $roleName = $this->faker->slug;
        $this->expectException(CannotDeleteRoleException::class);
        $this->resource->delete($roleName);
    }

    /**
     * @test
     */
    public function roles_can_be_deleted_by_name()
    {
        $roleName = $this->faker->slug;

        $this->resource
            ->create()
            ->name($roleName)
            ->save();

        $this->assertTrue($this->roleExists($roleName));

        $this->resource->delete($roleName);

        $this->assertFalse($this->roleExists($roleName));
    }

    /**
     * @test
     */
    public function roles_can_be_deleted_from_the_role_resource()
    {
        $roleName = $this->faker->slug;

        $this->resource
            ->create()
            ->name($roleName)
            ->save();

        $this->resource
            ->get($roleName)
            ->delete();

        $this->assertFalse($this->roleExists($roleName));
    }

    /**
     * @test
     */
    public function roles_can_be_updated() {

        $roleName = $this->faker->slug;

        $oldDescription = $this->faker->text;
        $newDescription = $this->faker->text;

        $this->resource
            ->create()
            ->name($roleName)
            ->description($oldDescription)
            ->save();

        $this->resource
            ->get($roleName)
            ->update()
            ->description($newDescription)
            ->save();

        $role = $this->resource
            ->get($roleName)
            ->toRepresentation();

        $this->assertEquals($newDescription, $role->getDescription());
    }
}