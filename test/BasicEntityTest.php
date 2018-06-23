<?php

namespace BasicEntity\Test;


use Entity\BasicEntity;
use PHPUnit\Framework\TestCase;

class BasicEntityTest extends TestCase
{
    public function test__get(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        $this->assertEquals('a', $entity->a);
        $entity->b = 'd';
        $entity->a = 'd';
        $this->assertEquals('d', $entity->a);
        $this->assertEquals('d', $entity->b);
    }

    public function test__isset(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        $this->assertTrue(isset($entity->a));
        $this->assertFalse(isset($entity->b));
    }

    public function testJsonSerialize(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        $this->assertJsonStringEqualsJsonString(json_encode(['a' => 'a']), json_encode($entity));
        $item = new Item([
            'a' => 1,
            'b' => 0,
            'c' => -1,
        ]);
        $item->setHidden(['a']);
        $this->assertJsonStringEqualsJsonString(json_encode(['b' => 0, 'c' => -1]), json_encode($item));
        $item->setVisible(['b']);
        $this->assertJsonStringEqualsJsonString(json_encode(['b' => 0]), json_encode($item));
        $item->setHidden([]);
        $this->assertJsonStringEqualsJsonString(json_encode(['b' => 0]), json_encode($item));
    }

    public function testOffsetExists(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        $this->assertTrue(isset($entity['a']));
        $this->assertFalse(isset($entity['b']));
    }

    public function testOffsetGet(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        $this->assertEquals('a', $entity['a']);
        $entity['b'] = 'd';
        $entity['a'] = 'd';
        $this->assertEquals('d', $entity['a']);
        $this->assertEquals('d', $entity['b']);
        $entity[] = 'g';
        $entity[] = 'f';
        $this->assertEquals('g', $entity[0]);
        $this->assertEquals('f', $entity[1]);
    }

    public function testOffsetUnset(): void
    {
        $entity = new BasicEntity(['a' => 'a']);
        unset($entity['a']);
        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($entity));
    }
}

class Item extends BasicEntity
{
    public $val = 1;

    public function setHidden(array $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function setVisible(array $visible): void
    {
        $this->visible = $visible;
    }
}