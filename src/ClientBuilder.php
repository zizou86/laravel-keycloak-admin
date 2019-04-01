<?php
namespace Keycloak\Admin;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Keycloak\Admin\Guzzle\DefaultHeadersMiddleware;
use Keycloak\Admin\Guzzle\TokenMiddleware;
use Keycloak\Admin\Hydrator\Hydrator;
use Keycloak\Admin\Resources\ResourceFactory;
use Keycloak\Admin\Resources\ResourceFactoryBuilder;
use Keycloak\Admin\Token\TokenManager;
use GuzzleHttp\Client as GuzzleClient;
use PhpDocReader\PhpDocReader;

class ClientBuilder
{
    private $guzzle;

    private $realm;

    private $serverUrl;

    private $clientId;

    private $clientSecret;

    private $token;

    private $username;

    private $password;

    private $tokenManager;

    public function __construct()
    {
    }

    public function withGuzzle(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
        return $this;
    }

    public function withRealm($realm)
    {
        $this->realm = $realm;
        return $this;
    }

    public function withServerUrl(string $url)
    {
        $this->serverUrl = $url;
        return $this;
    }

    public function withClientId(string $clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function withClientSecret(string $secret)
    {
        $this->clientSecret = $secret;
        return $this;
    }

    public function withUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    public function withPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function withAuthToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    private function buildGuzzle()
    {
        return new GuzzleClient([
            'base_uri' => $this->serverUrl,
            'http_errors' => false
        ]);
    }

    private function buildTokenManager(ClientInterface $guzzle)
    {
        return new TokenManager(
            $this->username,
            $this->password,
            $this->clientId,
            $guzzle
        );
    }

    public function build()
    {
        $guzzle = $this->guzzle ?? $this->buildGuzzle();

        if (null == ($tokenManager = $this->tokenManager)) {
            $tokenManager = $this->buildTokenManager($guzzle);
        }

        $tokenMiddleware = new TokenMiddleware($tokenManager);

        $stack = HandlerStack::create();

        $stack->push($tokenMiddleware);
        $stack->push(new DefaultHeadersMiddleware());

        $client = new GuzzleClient([
            'http_errors' => false,
            'handler' => $stack,
            'base_uri' => $this->serverUrl
        ]);

        $factory = new ResourceFactory($client, new Hydrator());

        return new Client($factory);
    }
}
