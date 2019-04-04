<?php
namespace Scito\Keycloak\Admin;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Scito\Keycloak\Admin\Guzzle\DefaultHeadersMiddleware;
use Scito\Keycloak\Admin\Guzzle\TokenMiddleware;
use Scito\Keycloak\Admin\Hydrator\Hydrator;
use Scito\Keycloak\Admin\Resources\ResourceFactory;
use Scito\Keycloak\Admin\Token\TokenManager;
use GuzzleHttp\Client as GuzzleClient;

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

    /**
     * @param ClientInterface $guzzle
     * @return ClientBuilder
     */
    public function withGuzzle(ClientInterface $guzzle): self
    {
        $this->guzzle = $guzzle;
        return $this;
    }

    /**
     * @param null|string $realm
     * @return ClientBuilder
     */
    public function withRealm(?string $realm): self
    {
        $this->realm = $realm;
        return $this;
    }

    /**
     * @param null|string $url
     * @return ClientBuilder
     */
    public function withServerUrl(?string $url): self
    {
        $this->serverUrl = $url;
        return $this;
    }

    /**
     * @param null|string $clientId
     * @return ClientBuilder
     */
    public function withClientId(?string $clientId): self
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param null|string $secret
     * @return ClientBuilder
     */
    public function withClientSecret(?string $secret): self
    {
        $this->clientSecret = $secret;
        return $this;
    }

    /**
     * @param null|string $username
     * @return ClientBuilder
     */
    public function withUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param null|string $password
     * @return ClientBuilder
     */
    public function withPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param null|string $token
     * @return ClientBuilder
     */
    public function withAuthToken(?string $token): self
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

        return new Client($factory, $this->realm);
    }
}
