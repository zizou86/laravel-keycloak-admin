<?php

namespace Scito\Keycloak\Admin\Token;

use DateInterval;
use GuzzleHttp\Client;
use RuntimeException;
use function date_create;
use function json_decode;

class TokenManager
{
    /**
     * @var Token[]
     */
    private $tokens;

    private $username;

    private $password;

    private $client;

    private $clientId;

    private $clientSecret;

    public function __construct($username, $password, $clientId, Client $client, $clientSecret = null)
    {
        $this->tokens = [];
        $this->username = $username;
        $this->password = $password;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->client = $client;
    }

    /**
     * @param $realm
     * @return Token
     */
    public function getToken($realm)
    {
        if (isset($this->tokens[$realm]) && $this->tokens[$realm]->isValid()) {
            return $this->tokens[$realm];
        }

        $params = [
            'username' => $this->username,
            'password' => $this->password,
            'client_id' => $this->clientId,
            'grant_type' => 'password'
        ];

        if(!is_null($this->clientSecret)){
            $params['client_secret'] = $this->clientSecret;
        }


        $response = $this->client->post("/auth/realms/master/protocol/openid-connect/token", [
            'form_params' => $params
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new RuntimeException("Error getting token");
        }

        $data = json_decode((string)$response->getBody(), true);

        $expires = date_create()->add(new DateInterval(sprintf('PT%dS', $data['expires_in'])));

        $this->tokens[$realm] = new Token($data['token_type'], $data['access_token'], $expires);

        return $this->tokens[$realm];
    }
}
