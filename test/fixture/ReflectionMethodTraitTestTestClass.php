<?php
namespace PHPUnit\Helper\fixture;

class ReflectionMethodTraitTestTestClass {
    public static $nonStaticCallParameters = [];
    public static $staticCallParameters = [];

    /**
     * this is lol or not nuff
     */
    public function method() {
    }

    protected function callNonStatic(...$parameters) {
        self::$nonStaticCallParameters[] = $parameters;

        return 'abc';
    }
    protected static function callStatic(...$parameters) {
        self::$staticCallParameters[] = $parameters;

        return 'def';
    }
}
