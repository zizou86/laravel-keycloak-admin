<?php
namespace Keycloak\Admin\Resources;

interface RoleMappingResourceInterface
{
    public function all();

    public function realm();

    public function client();
}
