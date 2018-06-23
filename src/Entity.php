<?php

namespace Entity;

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
class Entity extends \Entity\Base\Entity
{

}
