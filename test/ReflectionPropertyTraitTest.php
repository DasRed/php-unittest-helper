<?php

namespace PHPUnit\Helper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PHPUnit\Helper\fixture\ReflectionPropertyTraitTestTestClass;

/**
 * @coversDefaultClass \PHPUnit\Helper\ReflectionPropertyTrait
 */
class ReflectionPropertyTraitTest extends TestCase {
    use ReflectionMethodTrait;

    /**
     * @covers ::assertPropertyAnnotationContains
     */
    public function testAssertPropertyAnnotationContains() {
        $trait = new class extends TestCase {
            use ReflectionPropertyTrait;
        };

        $trait->assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'lol');
        $trait->assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'nuff');
    }

    /**
     * @covers ::getValue
     * @covers ::setValue
     */
    public function testGetSetValue() {
        $trait = $this->getMockBuilder(ReflectionPropertyTrait::class)->getMockForTrait();

        $obj = new ReflectionPropertyTraitTestTestClass();
        $result = $this->invoke($trait, 'getValue', [$obj, 'value']);
        self::assertSame('abc', $result);

        $this->invoke($trait, 'setValue', [$obj, 'value', 'nuff']);
        $result = $this->invoke($trait, 'getValue', [$obj, 'value']);
        self::assertSame('nuff', $result);
    }

    /**
     * @covers ::getValueStatic
     * @covers ::setValueStatic
     */
    public function testGetSetValueStatic() {
        $trait = $this->getMockBuilder(ReflectionPropertyTrait::class)->getMockForTrait();

        $result = $this->invoke($trait, 'getValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic']);
        self::assertSame('def', $result);

        $this->invoke($trait, 'setValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic', 'narf']);
        $result = $this->invoke($trait, 'getValueStatic', [ReflectionPropertyTraitTestTestClass::class, 'valueStatic']);
        self::assertSame('narf', $result);
    }

    /**
     * @covers ::getValueDefault
     */
    public function testGetValueDefault() {
        $trait = $this->getMockBuilder(ReflectionPropertyTrait::class)->getMockForTrait();

        $obj = new ReflectionPropertyTraitTestTestClass();
        $obj->setValue('feiorwpfgjeiorq');

        $result = $this->invoke($trait, 'getValueDefault', [ReflectionPropertyTraitTestTestClass::class, 'value']);

        self::assertSame('abc', $result);
    }

    /**
     * @covers ::getValueDefault
     */
    public function testGetValueDefaultPropertyDoesNotExists() {
        $trait = $this->getMockBuilder(ReflectionPropertyTrait::class)->getMockForTrait();

        $result = $this->invoke($trait, 'getValueDefault', [ReflectionPropertyTraitTestTestClass::class, 'htrdehbfgdr']);

        self::assertNull($result);
    }
}
