<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionException;

trait TestMockTrait
{
    public function createMockMock(string $class, string ...$methods): MockObject
    {
        if (count($methods) === 0) {
            return $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
        }

        $builder = $this->getMockBuilder($class);

        try {
            $reflector = new ReflectionClass($class);
            $addMethods = [];
            $onlyMethods = [];

            foreach ($methods as $method) {
                if ($reflector->hasMethod($method) === true) {
                    $onlyMethods[] = $method;
                }
                else {
                    $addMethods[] = $method;
                }
            }

            if (count($onlyMethods) !== 0) {
                $builder->onlyMethods($onlyMethods);
            }

            if (count($addMethods) !== 0) {
                $builder->addMethods($addMethods);
            }
            // @codeCoverageIgnoreStart
        } catch (ReflectionException $e) {
        }
        // @codeCoverageIgnoreEnd

        return $builder->disableOriginalConstructor()->getMock();
    }

    abstract public function getMockBuilder(string $className): MockBuilder;
}
