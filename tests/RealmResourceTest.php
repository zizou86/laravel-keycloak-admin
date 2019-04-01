<?php
namespace Keycloak\Admin\Tests;

use Keycloak\Admin\Representations\RealmRepresentationInterface;
use Keycloak\Admin\Tests\Traits\WithFaker;
use Keycloak\Admin\Tests\Traits\WithTestClient;

class RealmResourceTest extends TestCase
{
    use WithFaker, WithTestClient;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function realm_details_can_be_retrieved()
    {
        $realm = $this->client->realm('master')->toRepresentation();

        $this->assertInstanceOf(RealmRepresentationInterface::class, $realm);
    }
    
    /**
     * @test
     */
    public function realms_can_be_created() {
        
        $name = $this->faker->name;
        
        $this->client->realms()
            ->create()
            ->name($name)
            ->save();
    }
}