<?php

namespace DasRed\PHPUnit\Helper;

use DasRed\PHPUnit\Helper\fixture\ReflectionMethodTraitTestTestClass;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\ReflectionMethodTrait
 */
class ReflectionMethodTraitTest extends TestCase {
    use ReflectionMethodTrait;

    protected function tearDown(): void {
        ReflectionMethodTraitTestTestClass::$nonStaticCallParameters = [];
        ReflectionMethodTraitTestTestClass::$staticCallParameters = [];
        parent::tearDown();
    }

    /**
     * @covers ::assertMethodAnnotationContains
     */
    public function testAssertMethodAnnotationContains() {
        static::assertMethodAnnotationContains(ReflectionMethodTraitTestTestClass::class, 'method', 'lol');
        static::assertMethodAnnotationContains(ReflectionMethodTraitTestTestClass::class, 'method', 'nuff');
    }

    /**
     * @covers ::invoke
     */
    public function testInvoke() {
        $obj = new ReflectionMethodTraitTestTestClass();
        $result = static::invokeStatic(ReflectionMethodTrait::class, 'invoke', [$obj, 'callNonStatic', ['a', 1, 2]]);

        static::assertSame('abc', $result);
        static::assertSame([['a', 1, 2]], ReflectionMethodTraitTestTestClass::$nonStaticCallParameters);
        static::assertSame([], ReflectionMethodTraitTestTestClass::$staticCallParameters);
    }

    /**
     * @covers ::invokeStatic
     */
    public function testInvokeStatic() {
        $result = static::invokeStatic(ReflectionMethodTrait::class, 'invokeStatic', [ReflectionMethodTraitTestTestClass::class, 'callStatic', ['a', 1, 2]]);

        static::assertSame('def', $result);
        static::assertSame([['a', 1, 2]], ReflectionMethodTraitTestTestClass::$staticCallParameters);
        static::assertSame([], ReflectionMethodTraitTestTestClass::$nonStaticCallParameters);
    }
}
