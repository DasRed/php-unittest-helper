<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\TestCase;
use DasRed\PHPUnit\Helper\fixture\ReflectionClassTraitTestTestClass;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\ReflectionClassTrait
 */
class ReflectionClassTraitTest extends TestCase {
    use ReflectionClassTrait;

    /**
     * @covers ::assertClassAnnotationContains
     */
    public function testAssertClassAnnotationContains() {
        static::assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'lol');
        static::assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'nuff');
    }
}
