<?php

namespace Entity\Base;

abstract class IdBasedEntity extends Entity
{
    protected $id;

    final public function __construct($id, array $settings = [])
    {
        $this->id = $id;
        parent::__construct($settings);
    }
}