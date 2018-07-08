<?php

namespace Entity;

/**
 * The Entity class implements magic getters and setter allow object to be used as arrays and having the additional benefit of strict typing from PHP
 *
 *
 * Usage
 * ```php
 *
 * $item = new Entity(1, ['fieldA' => 'value']);
 *
 * echo $item->fieldA;
 * echo $item['fieldA'];
 *
 * ```
 */
class IdBasedBasicEntity extends \Entity\Base\IdBasedBasicEntity
{

}
