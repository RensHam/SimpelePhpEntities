<?php

namespace Entity;

/**
 * The BasicEntity is probably faster than the Entity class but doesn't have magic getters and setters.
 *
 * It makes an array accessible via properties and allow for easy json serialize.
 *
 *
 * ```php
 * $item = new BasicEntity(['a' => 4747]);
 *
 * echo $item->a;
 * ```
 *
 * This would print 4747
 */
class BasicEntity extends \Entity\Base\BasicEntity
{
    final public function __construct(array $settings = [])
    {
        parent::__construct($settings);
    }
}