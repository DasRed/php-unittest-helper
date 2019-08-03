<?php

namespace DasRed\PHPUnit\Helper;

use DasRed\PHPUnit\Helper\fixture\ReflectionPropertyTraitTestExtendsClass;
use DasRed\PHPUnit\Helper\fixture\ReflectionPropertyTraitTestTestClass;
use Exception;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\ReflectionPropertyTrait
 */
class ReflectionPropertyTraitTest extends TestCase {
    use ReflectionPropertyTrait;

    /**
     * @covers ::assertPropertyAnnotationContains
     * @throws ReflectionException
     */
    public function testAssertPropertyAnnotationContains() {
        static::assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'lol');
        static::assertPropertyAnnotationContains(ReflectionPropertyTraitTestTestClass::class, 'property', 'nuff');
    }

    /**
     * @covers ::getValue
     * @covers ::setValue
     * @throws ReflectionException
     * @throws Exception
     */
    public function testGetSetValue() {
        $obj = new ReflectionPropertyTraitTestTestClass();
        $result = static::getValue($obj, 'value');
        static::assertSame('abc', $result);

        static::setValue($obj, 'value', 'nuff');
        $result = static::getValue($obj, 'value');
        static::assertSame('nuff', $result);
    }

    /**
     * @covers ::getValueStatic
     * @covers ::setValueStatic
     * @throws ReflectionException
     */
    public function testGetSetValueStatic() {
        $result = static::getValueStatic(ReflectionPropertyTraitTestTestClass::class, 'valueStatic');
        static::assertSame('def', $result);

        static::setValueStatic(ReflectionPropertyTraitTestTestClass::class, 'valueStatic', 'narf');
        $result = static::getValueStatic(ReflectionPropertyTraitTestTestClass::class, 'valueStatic');
        static::assertSame('narf', $result);
    }

    /**
     * @covers ::getValueDefault
     * @throws ReflectionException
     */
    public function testGetValueDefault() {
        $obj = new ReflectionPropertyTraitTestTestClass();
        $obj->setValue('feiorwpfgjeiorq');

        $result = static::getValueDefault(ReflectionPropertyTraitTestTestClass::class, 'value');

        static::assertSame('abc', $result);
    }

    /**
     * @covers ::getValueDefault
     * @throws ReflectionException
     */
    public function testGetValueDefaultPropertyDoesNotExists() {
        $result = static::getValueDefault(ReflectionPropertyTraitTestTestClass::class, 'htrdehbfgdr');
        static::assertNull($result);
    }

    /**
     * @covers ::getValue
     * @throws Exception
     */
    public function testGetValueFailed() {
        $obj = new ReflectionPropertyTraitTestExtendsClass();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Attribute "valuex" not found in object.');

        static::getValue($obj, 'valuex');
    }

    /**
     * @covers ::getValue
     * @throws Exception
     */
    public function testGetValuePublic() {
        $obj = new ReflectionPropertyTraitTestTestClass();
        $result = static::getValue($obj, 'pub');
        static::assertSame('abc', $result);

    }
}
