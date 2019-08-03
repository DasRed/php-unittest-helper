<?php

namespace DasRed\PHPUnit\Helper;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DasRed\PHPUnit\Helper\TestGetterSetterTrait
 */
class TestGetterSetterTraitTest extends TestCase {
    use ReflectionMethodTrait;
    use TestGetterSetterTrait;

    public function prepare() {
        $instance = new class {
            protected $a;

            protected $b;

            protected $c;

            protected function getA(): string {
                return $this->a;
            }

            protected function setA(string $a): self {
                $this->a = $a;

                /** @noinspection PhpIncompatibleReturnTypeInspection */
                return $this;
            }

            protected function getB(): \DateTime {
                return $this->b;
            }

            protected function setB(\DateTime $b): self {
                $this->b = $b;

                /** @noinspection PhpIncompatibleReturnTypeInspection */
                return $this;
            }

            protected function getC(): ?string {
                return $this->c;
            }

            protected function setC(?string $c): self {
                $this->c = $c;

                /** @noinspection PhpIncompatibleReturnTypeInspection */
                return $this;
            }
        };

        $dateA = \DateTime::createFromFormat('d.m.Y', '16.01.2012');
        $dateB = \DateTime::createFromFormat('d.m.Y', '19.01.2014');

        return [$instance, $dateA, $dateB];
    }

    /**
     * @covers ::validateGetterSetter
     */
    public function testValidateGetterSetter() {
        list($instance, $dateA, $dateB) = $this->prepare();

        static::validateGetterSetter($instance, 'getA', 'setA', 'a', 'b', false);
        static::validateGetterSetter($instance, 'getB', 'setB', $dateA, $dateB, false);
        static::validateGetterSetter($instance, 'getC', 'setC', 'c', 'd', true);
    }

    /**
     * @covers ::validateGetterSetterForProperty
     */
    public function testValidateGetterSetterProperty() {
        list($instance, $dateA, $dateB) = $this->prepare();

        static::validateGetterSetterForProperty($instance, 'a', 'a', 'b', false);
        static::validateGetterSetterForProperty($instance, 'b', $dateA, $dateB, false);
        static::validateGetterSetterForProperty($instance, 'c', 'c', 'd', true);
    }
}
