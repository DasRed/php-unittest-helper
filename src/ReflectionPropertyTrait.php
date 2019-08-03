<?php

namespace DasRed\PHPUnit\Helper;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

trait ReflectionPropertyTrait {
    public static function assertPropertyAnnotationContains(string $class, string $property, string $contains) {
        try {
            static::assertStringContainsString($contains, (new ReflectionProperty($class, $property))->getDocComment(), 'Annotation of property "' . $class . '::$' . $property . '" does not contains "' . $contains . '".');
        }
        catch (ReflectionException $e) {
            static::fail($e->getMessage());
        }
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

    abstract public static function fail(string $message = ''): void;

    /**
     * @param object $object
     * @param string $attributeName
     * @return mixed
     * @throws Exception
     */
    public static function getValue(object $object, string $attributeName) {
        $reflector = new ReflectionObject($object);

        do {
            try {
                $attribute = $reflector->getProperty($attributeName);

                if (!$attribute || $attribute->isPublic()) {
                    return $object->$attributeName;
                }

                $attribute->setAccessible(true);
                $value = $attribute->getValue($object);
                $attribute->setAccessible(false);

                return $value;
            }
            catch (ReflectionException $e) {
            }
        } while ($reflector = $reflector->getParentClass());

        throw new Exception(
            sprintf(
                'Attribute "%s" not found in object.',
                $attributeName
            )
        );
    }

    /**
     * @param string $class
     * @param string $name
     * @return mixed
     */
    public static function getValueDefault(string $class, string $name) {
        try {
            $reflection = new ReflectionClass($class);
        }
        catch (ReflectionException $e) {
            static::fail($e->getMessage());

            return null;
        }

        $values = $reflection->getDefaultProperties();
        if (array_key_exists($name, $values) === false) {
            return null;
        }

        return $values[$name];
    }

    /**
     * @param string $class
     * @param string $name
     * @return mixed
     */
    public static function getValueStatic(string $class, string $name) {
        try {
            $reflectionProperty = new ReflectionProperty($class, $name);
        }
        catch (ReflectionException $e) {
            static::fail($e->getMessage());

            return null;
        }
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue();
    }

    /**
     * @param object $instance
     * @param string $name
     * @param mixed $value
     */
    public static function setValue(object $instance, string $name, $value) {
        try {
            $reflectionProperty = new ReflectionProperty($instance, $name);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($instance, $value);
        }
        catch (ReflectionException $e) {
            static::fail($e->getMessage());
        }
    }

    /**
     * @param string $class
     * @param string $name
     * @param mixed $value
     */
    public static function setValueStatic(string $class, string $name, $value) {
        try {
            $reflectionProperty = new ReflectionProperty($class, $name);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue(null, $value);
        }
        catch (ReflectionException $e) {
            static::fail($e->getMessage());
        }
    }
}
