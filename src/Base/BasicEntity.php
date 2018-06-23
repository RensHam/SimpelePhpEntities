<?php

namespace Entity\Base;

use Entity\EntityInterface;

/**
 * Use Entity/BasicEntity instead
 */
abstract class BasicEntity implements EntityInterface
{
    use BaseEntity;

    /**
     * @inheritdoc
     */
    final public function __isset(string $offset): bool
    {
        return array_key_exists($offset, $this->values);
    }

    /**
     * @inheritdoc
     */
    final public function &__get(string $offset)
    {
        return $this->values[$offset];
    }

    /**
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    final public function __set(string $offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    final public function jsonSerialize()
    {
        $data = $this->values;

        if (count($this->hidden)) {
            $data = array_diff_key($data, array_flip($this->hidden));
        }

        if (count($this->visible)) {
            $data = array_intersect_key($data, array_flip($this->visible));
        }

        return $data;
    }
}