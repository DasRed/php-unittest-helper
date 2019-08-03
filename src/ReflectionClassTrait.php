<?php

namespace DasRed\PHPUnit\Helper;

use ReflectionClass;
use ReflectionException;

trait ReflectionClassTrait {
    /**
     * @param string $class
     * @param string $contains
     * @throws ReflectionException
     */
    public static function assertClassAnnotationContains(string $class, string $contains): void {
        static::assertStringContainsString($contains, (new ReflectionClass($class))->getDocComment(), 'Annotation of class "' . $class . '" does not contains "' . $contains . '".');
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;
}
