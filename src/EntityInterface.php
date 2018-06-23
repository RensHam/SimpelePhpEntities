<?php
namespace Entity;

interface EntityInterface extends \JsonSerializable, \ArrayAccess
{
    /**
     * Get the array representation of the object.
     *
     * @return array
     */
    public function toArray(): array;
}