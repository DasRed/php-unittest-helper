<?php

namespace DasRed\PHPUnit\Helper;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

trait ReflectionPropertyTrait {
    /**
     * @param string $class
     * @param string $property
     * @param string $contains
     * @throws ReflectionException
     */
    public static function assertPropertyAnnotationContains(string $class, string $property, string $contains) {
        static::assertStringContainsString($contains, (new ReflectionProperty($class, $property))->getDocComment(), 'Annotation of property "' . $class . '::$' . $property . '" does not contains "' . $contains . '".');
    }

    abstract public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

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

        throw new Exception('Attribute "' . $attributeName . '" not found in object.');
    }

    /**
     * @param string $class
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public static function getValueDefault(string $class, string $name) {
        $reflection = new ReflectionClass($class);
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
     * @throws ReflectionException
     */
    public static function getValueStatic(string $class, string $name) {
        $reflectionProperty = new ReflectionProperty($class, $name);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue();
    }

    /**
     * @param object $instance
     * @param string $name
     * @param mixed $value
     * @throws ReflectionException
     */
    public static function setValue(object $instance, string $name, $value) {
        $reflectionProperty = new ReflectionProperty($instance, $name);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($instance, $value);
    }

    /**
     * @param string $class
     * @param string $name
     * @param mixed $value
     * @throws ReflectionException
     */
    public static function setValueStatic(string $class, string $name, $value) {
        $reflectionProperty = new ReflectionProperty($class, $name);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(null, $value);
    }
}
