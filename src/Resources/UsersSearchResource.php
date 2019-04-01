<?php
namespace Keycloak\Admin\Resources;

use ArrayObject;
use GuzzleHttp\ClientInterface;
use function http_build_query;
use function is_array;
use function json_decode;
use Keycloak\Admin\Exceptions\CannotRetrieveUsersException;
use Keycloak\Admin\Hydrator\HydratorInterface;
use Keycloak\Admin\Representations\RepresentationCollection;
use Keycloak\Admin\Representations\UserRepresentation;
use RuntimeException;

class UsersSearchResource implements UsersSearchResourceInterface
{
    use SearchableResource;

    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var ResourceFactoryInterface
     */
    private $resourceFactory;
    /**
     * @var string
     */
    private $realm;

    private $offset;

    private $limit;

    private $username;

    private $email;

    private $lastName;

    private $firstName;

    private $briefRepresentation;

    private $query;
    /**
     * @var HydratorInterface
     */
    private $hydrator;


    public function __construct(ClientInterface $client, ResourceFactoryInterface $resourceFactory, HydratorInterface $hydrator, string $realm)
    {
        $this->client = $client;
        $this->resourceFactory = $resourceFactory;
        $this->realm = $realm;
        $this->hydrator = $hydrator;
    }

    public function offset(int $offset = null): UsersSearchResourceInterface
    {
        return $this->withSearchOption('first', $offset);
    }

    public function limit(int $limit = null): UsersSearchResourceInterface
    {
        return $this->withSearchOption('max', $limit);
    }

    public function lastName(string $lastName): UsersSearchResourceInterface
    {
        return $this->withSearchOption('lastName', $lastName);
    }

    public function firstName(string $firstName): UsersSearchResourceInterface
    {
        return $this->withSearchOption('firstName', $firstName);
    }

    public function email(string $email): UsersSearchResourceInterface
    {
        return $this->withSearchOption('email', $email);
    }

    public function username(string $username): UsersSearchResourceInterface
    {
        return $this->withSearchOption('username', $username);
    }

    public function briefRepresentation(bool $briefRepresentation): UsersSearchResourceInterface
    {
        return $this->withSearchOption('briefRepresentation', $briefRepresentation);
    }

    public function query(string $query): UsersSearchResourceInterface
    {
        return $this->withSearchOption('search', $query);
    }

    public function __call($name, $arguments)
    {
        throw new RuntimeException("Unknown searchable method [$name]");
    }

    public function get()
    {
        $options = $this->getSearchOptions();
        $queryString = '';
        if (!empty($options)) {
            $queryString = '?' . http_build_query($options);
        }

        $response = $this->client->get("/auth/admin/realms/{$this->realm}/users{$queryString}");
        if (200 !== $response->getStatusCode()) {
            throw new CannotRetrieveUsersException("Unable to retrieve users");
        }

        $json = (string)$response->getBody();
        $users = json_decode($json, true);

        $items = array_map(function ($user) {
            return $this->hydrator->hydrate($user, UserRepresentation::class);
        }, $users);

        return new RepresentationCollection($items);
    }

    public function getIterator()
    {
        return $this->get();
    }

    public function first()
    {
        $result = $this->get();
        if (count($result) > 0) {
            return $result[0];
        }
        return null;
    }
}
