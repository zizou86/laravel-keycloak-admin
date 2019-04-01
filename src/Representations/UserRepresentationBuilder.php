<?php
namespace Keycloak\Admin\Representations;

use function is_array;
use Keycloak\Admin\Hydrator\Hydrator;
use Keycloak\Admin\Hydrator\HydratorInterface;

class UserRepresentationBuilder extends AbstractRepresentationBuilder implements UserRepresentationBuilderInterface
{
    public function withId(string $id): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('id', $id);
    }

    public function withUsername(string $username): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('username', $username);
    }

    public function withPassword(string $password): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('password', $password);
    }

    public function withEnabled(bool $enabled): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('enabled', $enabled);
    }

    public function withEmail(string $email): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('email', $email);
    }

    public function build(): UserRepresentationInterface
    {
        $data = $this->getAttributes();
        if (isset($data['password'])) {
            $password = $data['password'];
            unset($data['password']);

            if (!is_array($data['credentials'])) {
                $data['credentials'] = [];
            }
            $data['credentials'][] = [
                'type' => 'password',
                'value' => $password
            ];
        }
        $hydrator = new Hydrator();
        return $hydrator->hydrate($data, UserRepresentation::class);
    }
}
