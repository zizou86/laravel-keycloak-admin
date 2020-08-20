# Keycloak Admin Library

## Basic usage example
```php
$client = (new ClientBuilder())
    ->withServerUrl($server)
    ->withClientId($clientId)
    ->withUsername($keycloakUsername)
    ->withPassword($keycloakPassword)
    ->build();
    
// Add a user
$client->realm('master')
    ->users()
    ->create()
    ->username($username)
    ->password($password)
    ->email($email)
    ->emailVerified(true)
    ->enabled(true)
    ->attributes([
        'lang' => $lang,
        'birthdate' => $birth_date
    ])
    ->save();
```