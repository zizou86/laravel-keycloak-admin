<?php
namespace Keycloak\Admin\Representations;

use function array_key_exists;
use function is_array;
use function json_encode;

abstract class AbstractRepresentation
{
    protected $attributes = [];

    public static function create(array $attributes = [])
    {
        $instance = new static();
        foreach ($attributes as $k => $v) {
            $instance->setAttribute($k, $v);
        }
        return $instance;
    }

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

    private function convertValue($value)
    {
        if ($value instanceof Representation) {
            return $value->toArray();
        } elseif (is_array($value)) {
            $result = [];
            foreach ($value as $k => $v) {
                if (null !== $v) {
                    $result[$k] = $this->convertValue($v);
                }
            }
            return $result;
        }
        return $value;
    }

    protected function recursiveToArray()
    {
        $result = [];
        foreach ($this->getAttributes() as $key => $value) {
            if (null !== $value) {
                $result[$key] = $this->convertValue($value);
            }
        }
        return $result;
    }

    public function toArray(): array
    {
        return $this->recursiveToArray();
    }

    public function toJson(): string
    {
        return json_encode((object)$this->toArray());
    }
}
