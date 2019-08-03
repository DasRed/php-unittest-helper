<?php

namespace DasRed\PHPUnit\Helper;

use DasRed\PHPUnit\Helper\fixture\ReflectionPropertyTraitTestTestClass;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\ReflectionPropertyTrait
 */
class ReflectionPropertyTraitTest extends TestCase {
    use ReflectionMethodTrait;
    use ReflectionPropertyTrait;

    /**
     * @covers ::assertPropertyAnnotationContains
     */
    public function testAssertPropertyAnnotationContains() {
        static::assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'lol');
        static::assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'nuff');
    }

    /**
     * @covers ::getValue
     * @covers ::setValue
     */
    public function testGetSetValue() {
        $obj = new ReflectionPropertyTraitTestTestClass();
        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValue', [$obj, 'value']);
        static::assertSame('abc', $result);

        static::invokeStatic(ReflectionPropertyTrait::class, 'setValue', [$obj, 'value', 'nuff']);
        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValue', [$obj, 'value']);
        static::assertSame('nuff', $result);
    }

    /**
     * @covers ::getValueStatic
     * @covers ::setValueStatic
     */
    public function testGetSetValueStatic() {
        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic']);
        static::assertSame('def', $result);

        static::invokeStatic(ReflectionPropertyTrait::class, 'setValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic', 'narf']);
        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic']);
        static::assertSame('narf', $result);
    }

    /**
     * @covers ::getValueDefault
     */
    public function testGetValueDefault() {
        $obj = new ReflectionPropertyTraitTestTestClass();
        $obj->setValue('feiorwpfgjeiorq');

        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValueDefault', [ReflectionPropertyTraitTestTestClass::class, 'value']);

        static::assertSame('abc', $result);
    }

    /**
     * @covers ::getValueDefault
     */
    public function testGetValueDefaultPropertyDoesNotExists() {
        $result = static::invokeStatic(ReflectionPropertyTrait::class, 'getValueDefault', [ReflectionPropertyTraitTestTestClass::class, 'htrdehbfgdr']);
        static::assertNull($result);
    }
}
