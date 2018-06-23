<?php

namespace Entity\Base;

use Entity\EntityInterface;
use Entity\Exception\InvalidCallException;

/**
 * Use Entity/Entity instead in normal cases.
 */
abstract class Entity implements EntityInterface
{
    use BaseEntity;

    /**
     * @param $name
     * @return mixed
     */
    final public function &__get($name)
    {
        $getter = "get{$name}";
        $setter = "set{$name}";
        if (method_exists($this, $getter)) {
            $val = $this->$getter();
            return $val;
        }
        if (!array_key_exists($name, $this->values) && method_exists($this, $setter)) {
            throw new InvalidCallException("Property: {$name} is write only");
        }
        return $this->values[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    final public function __set($name, $value)
    {
        $getter = "get{$name}";
        $setter = "set{$name}";
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (!array_key_exists($name, $this->values) && method_exists($this, $getter)) {
            throw new InvalidCallException("Property: {$name} is read only");
        }

        $this->values[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    final public function __isset($name): bool
    {
        $getter = "get{$name}";
        if (method_exists($this, $getter)) {
            return true;
        }

        return array_key_exists($name, $this->values);
    }

    /**
     * {@inheritdoc}
     */
    final public function jsonSerialize()
    {
        return $this->values();
    }

    /**
     * @inheritdoc
     */
    final public function toArray(): array
    {
        return $this->values();
    }

    private function values(): array
    {
        $data = $this->values;

        foreach (get_class_methods($this) as $method) {
            if (!in_array($method, ['get', 'set']) && strpos($method, 'get') === 0) {
                $data[lcfirst(substr($method, 3))] = $this->$method();
            }
        }

        if (count($this->hidden)) {
            $data = array_diff_key($data, array_flip($this->hidden));
        }

        if (count($this->visible)) {
            $data = array_intersect_key($data, array_flip($this->visible));
        }

        return $data;
    }
}
