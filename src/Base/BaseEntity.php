<?php

namespace Entity\Base;

use Entity\EntityInterface;

/**
 * @var EntityInterface $this
 */
trait BaseEntity
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
        $this->hidden = $this->initHidden();
        $this->visible = $this->initVisible();
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
     * @param $offset
     * @return bool
     */
    abstract public function __isset($offset): bool;

    /**
     * @param $offset
     * @return mixed
     */
    abstract public function &__get($offset);

    /**
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    abstract public function __set(string $offset, $value): void;

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

    /**
     * Get an item from the saved array.
     *
     * @param string $item
     * @return mixed
     */
    final protected function get(string $item)
    {
        return $this->values[$item];
    }

    /**
     * Set an item in the saved array.
     *
     * @param string $item
     * @param mixed $val
     */
    final protected function set(string $item, $val): void
    {
        $this->values[$item] = $val;
    }

    protected function initHidden(): array
    {
        return [];
    }

    protected function initVisible(): array
    {
        return [];
    }
}