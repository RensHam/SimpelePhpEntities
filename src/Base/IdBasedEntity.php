<?php

namespace Entity\Base;

abstract class IdBasedEntity extends Entity
{
    /**
     * @var int
     */
    protected $id;

    final public function __construct(int $id, array $settings = [])
    {
        $this->id = $id;
        parent::__construct($settings);
    }
}