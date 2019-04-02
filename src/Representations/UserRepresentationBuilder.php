<?php
namespace Keycloak\Admin\Representations;

use function array_key_exists;
use function in_array;
use function is_array;
use Keycloak\Admin\Hydrator\Hydrator;

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
        $this->withPasswordIsTemporary(false);
        return $this->setAttribute('password', $password);
    }

    public function withTemporaryPassword(string $password): UserRepresentationBuilderInterface
    {
        $this->withPasswordIsTemporary(true);
        $actions = $this->getAttribute('requiredActions', []);
        if (!in_array('UPDATE_PASSWORD', $actions)) {
            $actions[] = 'UPDATE_PASSWORD';
            $this->withRequiredActions($actions);
        }
        return $this->setAttribute('password', $password);
    }

    public function withPasswordIsTemporary(bool $temporary): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('passwordIsTemporary', $temporary);
    }

    public function withRequiredActions(?array $actions): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('requiredActions', $actions);
    }

    public function withEnabled(bool $enabled): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('enabled', $enabled);
    }

    public function withEmail(string $email): UserRepresentationBuilderInterface
    {
        return $this->setAttribute('email', $email);
    }

    private function buildCredentials(&$data)
    {
        if (isset($data['password'])) {
            $password = $data['password'];
            unset($data['password']);

            if (!isset($data['credentials']) || !is_array($data['credentials'])) {
                $data['credentials'] = [];
            }

            $passwordCredential = [
                'type' => 'password',
                'value' => $password
            ];

            if (array_key_exists('passwordIsTemporary', $data)) {
                $passwordCredential['temporary'] = $data['passwordIsTemporary'];
            }

            $data['credentials'][] = $passwordCredential;
        }
    }

    public function build(): UserRepresentationInterface
    {
        $data = $this->getAttributes();
        $this->buildCredentials($data);
        $hydrator = new Hydrator();
        return $hydrator->hydrate($data, UserRepresentation::class);
    }
}
