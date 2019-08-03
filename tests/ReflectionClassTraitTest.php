<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\TestCase;
use DasRed\PHPUnit\Helper\fixture\ReflectionClassTraitTestTestClass;
use ReflectionException;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\ReflectionClassTrait
 */
class ReflectionClassTraitTest extends TestCase {
    use ReflectionClassTrait;

    /**
     * @covers ::assertClassAnnotationContains
     * @throws ReflectionException
     */
    public function testAssertClassAnnotationContains() {
        static::assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'lol');
        static::assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'nuff');
    }
}
