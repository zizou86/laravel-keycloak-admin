<?php
namespace Scito\Keycloak\Admin\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function assertValidKeycloakId($id)
    {
        $this->assertTrue(
            filter_var(preg_match('/^([a-z0-9\-]){36}$/', $id), FILTER_VALIDATE_BOOLEAN)
        );
    }
}
