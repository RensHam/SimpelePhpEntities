<?php

namespace Entity;

use Entity\Exception\InvalidCallException;

/**
 * The Entity class implements magic getters and setter allow object to be used as arrays and having the additional benefit of strict typing from PHP
 *
 *
 * Usage
 * ```php
 *
 * $item = new Entity(['fieldA' => 'value']);
 *
 * echo $item->fieldA;
 * echo $item['fieldA'];
 *
 * ```
 */
class Entity implements EntityInterface
{

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $visible = [];

    final public function __construct(array $values = [])
    {
        $this->values = $values;
        $this->initialize();
    }

    /**
     * Override this method if it is required to do some initialization tasks.
     *
     * @return void
     */
    protected function initialize(): void
    {
    }

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
        $data = $this->values;

        foreach (get_class_methods($this) as $method) {
            if (strpos($method, 'get') === 0) {
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

    /**
     * {@inheritdoc}
     */
    final public function offsetExists($offset): bool
    {
        return $this->__isset($offset);
    }

    /**
     * {@inheritdoc}
     */
    final public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * {@inheritdoc}
     */
    final public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->values[] = $value;
        } else {
            $this->__set($offset, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }
}
