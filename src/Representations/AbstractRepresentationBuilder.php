<?php
namespace Keycloak\Admin\Representations;

use function array_key_exists;
use function is_array;
use function json_encode;

abstract class AbstractRepresentationBuilder
{
    protected $attributes = [];

    protected function getAttribute($key, $default = null)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default;
    }

    protected function setAttributes(array $attributes)
    {
        foreach ($attributes as $k => $v) {
            $this->setAttribute($k, $v);
        }
        return $this;
    }

    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    protected function getAttributes()
    {
        return $this->attributes;
    }
}
