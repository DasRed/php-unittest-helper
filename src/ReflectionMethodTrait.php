<?php

namespace PHPUnit\Helper;

trait ReflectionMethodTrait {
    public function assertMethodAnnotationContains(string $class, string $method, string $contains): void {
        try {
            static::assertStringContainsString($contains, (new \ReflectionMethod($class, $method))->getDocComment(), 'Annotation of method "' . $class . '::' . $method . '" does not contains "' . $contains . '".');
        }
        catch (\ReflectionException $e) {
            static::fail($e->getMessage());
        }
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

    abstract public static function fail(string $message = ''): void;

    /**
     * @param object $instance
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function invoke(object $instance, string $name, array $arguments = []) {
        $result = null;

        try {
            $reflectionMethod = new \ReflectionMethod($instance, $name);
            $reflectionMethod->setAccessible(true);
            $result = $reflectionMethod->invokeArgs($instance, $arguments);
        }
        catch (\ReflectionException $e) {
            static::fail($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $class
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function invokeStatic(string $class, string $name, array $arguments = []) {
        $result = null;
        try {
            $reflectionMethod = new \ReflectionMethod($class, $name);
            $reflectionMethod->setAccessible(true);
            $result = $reflectionMethod->invokeArgs(null, $arguments);
        }
        catch (\ReflectionException $e) {
            static::fail($e->getMessage());
        }

        return $result;
    }
}
