<?php

namespace PHPUnit\Helper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \PHPUnit\Helper\TestMockTrait
 */
class TestMockTraitTest extends TestCase {
    use TestMockTrait;

    /**
     * @covers ::createMockMock
     */
    public function testCreateMockMockWithMethods() {
        $trait = new class extends TestCase {
            use TestMockTrait;
        };

        /** @var MockObject|\stdClass $result */
        $result = $trait->createMockMock(\stdClass::class, 'a', 'b');
        $result->expects(static::once())->method('a')->willReturn('a');
        $result->expects(static::once())->method('b')->willReturn('b');

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertInstanceOf(MockObject::class, $result);
        static::assertEquals('a', $result->a());
        static::assertEquals('b', $result->b());
    }

    /**
     * @covers ::createMockMock
     */
    public function testCreateMockMockWithoutMethods() {
        $trait = new class extends TestCase {
            use TestMockTrait;
        };

        /** @var MockObject|\stdClass $result */
        $result = $trait->createMockMock(\stdClass::class);

        static::assertInstanceOf(\stdClass::class, $result);
        static::assertInstanceOf(MockObject::class, $result);
    }
}
