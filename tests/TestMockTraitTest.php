<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\TestMockTrait
 */
class TestMockTraitTest extends TestCase
{
    use TestMockTrait;

    /**
     * @covers ::createMockMock
     */
    public function testCreateMockMockWithMethods()
    {
        /** @var MockObject|TestMockTraitTest $result */
        $result = $this->createMockMock(TestMockTraitTest::class, 'a', 'b', 'testCreateMockMockWithMethods');
        $result->expects(static::once())->method('a')->willReturn('a');
        $result->expects(static::once())->method('b')->willReturn('b');
        $result->expects(static::once())->method('testCreateMockMockWithMethods');

        static::assertInstanceOf(TestMockTraitTest::class, $result);
        static::assertInstanceOf(MockObject::class, $result);
        /** @noinspection PhpUndefinedMethodInspection */
        static::assertEquals('a', $result->a());
        /** @noinspection PhpUndefinedMethodInspection */
        static::assertEquals('b', $result->b());
        static::assertNull($result->testCreateMockMockWithMethods());
    }

    /**
     * @covers ::createMockMock
     */
    public function testCreateMockMockWithoutMethods()
    {
        /** @var MockObject|stdClass $result */
        $result = $this->createMockMock(stdClass::class);

        static::assertInstanceOf(stdClass::class, $result);
        static::assertInstanceOf(MockObject::class, $result);
    }
}
