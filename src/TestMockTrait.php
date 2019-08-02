<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;

trait TestMockTrait {
    public function createMockMock(string $class, string ...$methods): MockObject {
        if (count($methods) === 0) {
            return $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
        }

        return $this->getMockBuilder($class)->setMethods($methods)->disableOriginalConstructor()->getMock();
    }

    abstract public function getMockBuilder($className): MockBuilder;
}
