<?php

namespace PHPUnit\Helper;

use PHPUnit\Framework\TestCase;
use PHPUnit\Helper\fixture\ReflectionClassTraitTestTestClass;

/**
 * @coversDefaultClass \PHPUnit\Helper\ReflectionClassTrait
 */
class ReflectionClassTraitTest extends TestCase {

    /**
     * @covers ::assertClassAnnotationContains
     */
    public function testAssertClassAnnotationContains() {
        $trait = new class extends TestCase {
            use ReflectionClassTrait;
        };

        $trait->assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'lol');
        $trait->assertClassAnnotationContains(ReflectionClassTraitTestTestClass::class, 'nuff');
    }
}
