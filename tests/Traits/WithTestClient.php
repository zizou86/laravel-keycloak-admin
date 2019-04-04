<?php
namespace Scito\Keycloak\Admin\Tests\Traits;

use Scito\Keycloak\Admin\Client;
use Scito\Keycloak\Admin\ClientBuilder;

trait WithTestClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @before
     */
    public function setupClientClass()
    {
        $this->client = $this->makeClient();
    }
    /**
     * @after
     */
    public function teardownClientClass()
    {
        $this->client = null;
    }

    protected function makeClient()
    {
        return (new ClientBuilder())
            ->withRealm($_SERVER['REALM'] ?? null)
            ->withServerUrl($_SERVER['SERVER_URL'])
            ->withClientId($_SERVER['CLIENT_ID'])
            ->withUsername($_SERVER['USERNAME'])
            ->withPassword($_SERVER['PASSWORD'])
            ->build();
    }
}