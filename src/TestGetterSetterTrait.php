<?php

namespace PHPUnit\Helper;

use DateTime;

trait TestGetterSetterTrait {
    abstract public static function assertEquals($expected, $actual, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    abstract public static function assertNull($actual, string $message = ''): void;

    abstract public function invoke(object $instance, string $name, array $arguments = []);

    /**
     * @param object $instance
     * @param string $getter
     * @param string $setter
     * @param mixed $valueA
     * @param mixed $valueB
     * @param bool $nullable
     */
    public function validateGetterSetter(object $instance, string $getter, string $setter, $valueA, $valueB, bool $nullable = false) {
        static::assertEquals($instance, $this->invoke($instance, $setter, [$valueA]));

        $resultA = $this->invoke($instance, $getter);
        if ($valueA instanceof DateTime) {
            /** @var DateTime $resultA */
            static::assertInstanceOf(DateTime::class, $resultA);
            static::assertEquals($valueA->getTimestamp(), $resultA->getTimestamp());
        }
        else {
            static::assertEquals($valueA, $resultA);
        }

        static::assertEquals($instance, $this->invoke($instance, $setter, [$valueB]));
        $resultB = $this->invoke($instance, $getter);
        if ($valueB instanceof DateTime) {
            /** @var DateTime $resultB */
            static::assertInstanceOf(DateTime::class, $resultB);
            static::assertEquals($valueB->getTimestamp(), $resultB->getTimestamp());
        }
        else {
            static::assertEquals($valueB, $resultB);
        }

        if ($nullable === true) {
            static::assertEquals($instance, $this->invoke($instance, $setter, [null]));
            static::assertNull($this->invoke($instance, $getter));
        }
    }

    /**
     * /**
     * @param object $instance
     * @param string $property
     * @param mixed $valueA
     * @param mixed $valueB
     * @param string $getterPrefix
     * @param bool $nullable
     */
    public function validateGetterSetterForBooleanProperty(object $instance, string $property, $valueA, $valueB, string $getterPrefix = 'is', bool $nullable = false): void {
        $this->validateGetterSetter($instance, strtolower($getterPrefix) . ucfirst($property), 'set' . ucfirst($property), $valueA, $valueB, $nullable);
    }

    /**
     * @param object $instance
     * @param string $property
     * @param mixed $valueA
     * @param mixed $valueB
     * @param bool $nullable
     */
    public function validateGetterSetterForProperty(object $instance, string $property, $valueA, $valueB, bool $nullable = false) {
        $this->validateGetterSetter($instance, 'get' . ucfirst($property), 'set' . ucfirst($property), $valueA, $valueB, $nullable);
    }
}
