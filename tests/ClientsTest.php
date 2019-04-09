<?php
namespace Scito\Keycloak\Admin\Tests;

use Scito\Keycloak\Admin\Representations\ClientRepresentationInterface;
use Scito\Keycloak\Admin\Tests\Traits\WithTestClient;

class ClientsTest extends TestCase
{
    use WithTestClient;

    /**
     * @test
     */
     public function clients_can_be_retrieved() {
         $client = $this->client
             ->realm('master')
             ->clients()
             ->all()
             ->first(function(ClientRepresentationInterface $client) {
                 return 'account' === $client->getClientId();
             });

         $this->assertInstanceOf(ClientRepresentationInterface::class, $client);
     }
}