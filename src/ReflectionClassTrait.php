<?php

namespace DasRed\PHPUnit\Helper;

trait ReflectionClassTrait {
    public function assertClassAnnotationContains(string $class, string $contains): void {
        try {
            static::assertStringContainsString($contains, (new \ReflectionClass($class))->getDocComment(), 'Annotation of class "' . $class . '" does not contains "' . $contains . '".');
        }
        catch (\ReflectionException $e) {
            static::fail($e->getMessage());
        }
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

    abstract public static function fail(string $message = ''): void;
}
