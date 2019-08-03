<?php

namespace DasRed\PHPUnit\Helper;

use ReflectionException;
use ReflectionMethod;

trait ReflectionMethodTrait {
    /**
     * @param string $class
     * @param string $method
     * @param string $contains
     * @throws ReflectionException
     */
    public static function assertMethodAnnotationContains(string $class, string $method, string $contains): void {
        static::assertStringContainsString($contains, (new ReflectionMethod($class, $method))->getDocComment(), 'Annotation of method "' . $class . '::' . $method . '" does not contains "' . $contains . '".');
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

    /**
     * @param object $instance
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws ReflectionException
     */
    public static function invoke(object $instance, string $name, array $arguments = []) {
        $reflectionMethod = new ReflectionMethod($instance, $name);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs($instance, $arguments);
    }

    /**
     * @param string $class
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws ReflectionException
     */
    public static function invokeStatic(string $class, string $name, array $arguments = []) {
        $reflectionMethod = new ReflectionMethod($class, $name);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invokeArgs(null, $arguments);
    }
}
