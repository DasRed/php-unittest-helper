<?php

namespace DasRed\PHPUnit\Helper\fixture;

class ReflectionPropertyTraitTestTestClass {
    /**
     * this is lol or not nuff
     */
    protected $property;

    public $pub = 'abc';

    protected $value = 'abc';

    protected static $valueStatic = 'def';

    public function setValue($x) {
        $this->value = $x;

        return $this;
    }

}
