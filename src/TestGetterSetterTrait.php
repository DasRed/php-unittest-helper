<?php

namespace DasRed\PHPUnit\Helper;

use DateTime;

trait TestGetterSetterTrait {
    abstract public static function assertEquals($expected, $actual, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void;

    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;

    abstract public static function assertNull($actual, string $message = ''): void;

    abstract public static function invoke(object $instance, string $name, array $arguments = []);

    /**
     * @param object $instance
     * @param string $getter
     * @param string $setter
     * @param mixed $valueA
     * @param mixed $valueB
     * @param bool $nullable
     */
    public static function validateGetterSetter(object $instance, string $getter, string $setter, $valueA, $valueB, bool $nullable = false) {
        static::assertEquals($instance, static::invoke($instance, $setter, [$valueA]));

        $resultA = static::invoke($instance, $getter);
        if ($valueA instanceof DateTime) {
            /** @var DateTime $resultA */
            static::assertInstanceOf(DateTime::class, $resultA);
            static::assertEquals($valueA->getTimestamp(), $resultA->getTimestamp());
        }
        else {
            static::assertEquals($valueA, $resultA);
        }

        static::assertEquals($instance, static::invoke($instance, $setter, [$valueB]));
        $resultB = static::invoke($instance, $getter);
        if ($valueB instanceof DateTime) {
            /** @var DateTime $resultB */
            static::assertInstanceOf(DateTime::class, $resultB);
            static::assertEquals($valueB->getTimestamp(), $resultB->getTimestamp());
        }
        else {
            static::assertEquals($valueB, $resultB);
        }

        if ($nullable === true) {
            static::assertEquals($instance, static::invoke($instance, $setter, [null]));
            static::assertNull(static::invoke($instance, $getter));
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
    public static function validateGetterSetterForBooleanProperty(object $instance, string $property, $valueA, $valueB, string $getterPrefix = 'is', bool $nullable = false): void {
        static::validateGetterSetter($instance, strtolower($getterPrefix) . ucfirst($property), 'set' . ucfirst($property), $valueA, $valueB, $nullable);
    }

    /**
     * @param object $instance
     * @param string $property
     * @param mixed $valueA
     * @param mixed $valueB
     * @param bool $nullable
     */
    public static function validateGetterSetterForProperty(object $instance, string $property, $valueA, $valueB, bool $nullable = false) {
        static::validateGetterSetter($instance, 'get' . ucfirst($property), 'set' . ucfirst($property), $valueA, $valueB, $nullable);
    }
}
