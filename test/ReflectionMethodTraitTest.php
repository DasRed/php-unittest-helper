<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\TestCase;
use DasRed\PHPUnit\Helper\fixture\ReflectionMethodTraitTestTestClass;

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
        $trait = new class extends TestCase {
            use ReflectionMethodTrait;
        };

        $trait->assertMethodAnnotationContains(ReflectionMethodTraitTestTestClass::class, 'method', 'lol');
        $trait->assertMethodAnnotationContains(ReflectionMethodTraitTestTestClass::class, 'method', 'nuff');
    }

    /**
     * @covers ::invoke
     */
    public function testInvoke() {
        $trait = $this->getMockBuilder(ReflectionMethodTrait::class)->getMockForTrait();

        $obj = new ReflectionMethodTraitTestTestClass();
        $result = $this->invoke($trait, 'invoke', [$obj, 'callNonStatic', ['a', 1, 2]]);

        self::assertSame('abc', $result);
        self::assertSame([['a', 1, 2]], ReflectionMethodTraitTestTestClass::$nonStaticCallParameters);
        self::assertSame([], ReflectionMethodTraitTestTestClass::$staticCallParameters);
    }

    /**
     * @covers ::invokeStatic
     */
    public function testInvokeStatic() {
        $trait = $this->getMockBuilder(ReflectionMethodTrait::class)->getMockForTrait();

        $result = $this->invoke($trait, 'invokeStatic', [ReflectionMethodTraitTestTestClass::class, 'callStatic', ['a', 1, 2]]);

        self::assertSame('def', $result);
        self::assertSame([['a', 1, 2]], ReflectionMethodTraitTestTestClass::$staticCallParameters);
        self::assertSame([], ReflectionMethodTraitTestTestClass::$nonStaticCallParameters);
    }
}
