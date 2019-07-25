<?php

namespace PHPUnit\Helper;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \PHPUnit\Helper\TestGetterSetterTrait
 */
class TestGetterSetterTraitTest extends TestCase {
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

        $trait = new class extends TestCase {
            use ReflectionMethodTrait;
            use TestGetterSetterTrait;
        };

//        /* @var TestGetterSetterTrait|MockObject $trait */
//        $trait = $this->getMockBuilder(TestGetterSetterTrait::class)->setMethods(['invoke', 'assertEquals', 'assertInstanceOf', 'assertNull'])->getMockForTrait();
//        $trait->expects(self::exactly(4 + 6 + 6))->method('invoke')->withConsecutive(
//            [$instance, 'setA', ['a']],
//            [$instance, 'getA'],
//            [$instance, 'setA', ['b']],
//            [$instance, 'getA'],
//
//            [$instance, 'setB', [$dateA]],
//            [$instance, 'getB'],
//            [$instance, 'getB'],
//            [$instance, 'setB', [$dateB]],
//            [$instance, 'getB'],
//            [$instance, 'getB'],
//
//            [$instance, 'setC', ['c']],
//            [$instance, 'getC'],
//            [$instance, 'setC', ['d']],
//            [$instance, 'getC'],
//            [$instance, 'setC', [null]],
//            [$instance, 'getC']
//        )->willReturnOnConsecutiveCalls(
//            $instance,
//            'a',
//            $instance,
//            'b',
//            $instance,
//            $dateA,
//            $dateA,
//            $instance,
//            $dateB,
//            $dateB,
//            $instance,
//            'c',
//            $instance,
//            'd',
//            $instance,
//            null
//        );
//
//        $trait->expects(self::exactly(4 + 4 + 5))->method('assertEquals')->withConsecutive(
//            [$instance, $instance],
//            ['a', 'a'],
//            [$instance, $instance],
//            ['b', 'b'],
//
//            [$instance, $instance],
//            [$dateA->getTimestamp(), $dateA->getTimestamp()],
//            [$instance, $instance],
//            [$dateB->getTimestamp(), $dateB->getTimestamp()],
//
//            [$instance, $instance],
//            ['c', 'c'],
//            [$instance, $instance],
//            ['d', 'd'],
//            [$instance, $instance]
//        );
//
//        $trait->expects(self::exactly(2))->method('assertInstanceOf')->withConsecutive(
//            [\DateTime::class, $dateA],
//            [\DateTime::class, $dateB]
//        );
//
//        $trait->expects(self::once())->method('assertNull')->withConsecutive(
//            [null]
//        );

        return [$instance, $trait, $dateA, $dateB];
    }

    /**
     * @covers ::validateGetterSetter
     */
    public function testValidateGetterSetter() {
        list($instance, $trait, $dateA, $dateB) = $this->prepare();

        $trait->validateGetterSetter($instance, 'getA', 'setA', 'a', 'b', false);
        $trait->validateGetterSetter($instance, 'getB', 'setB', $dateA, $dateB, false);
        $trait->validateGetterSetter($instance, 'getC', 'setC', 'c', 'd', true);
    }

    /**
     * @covers ::validateGetterSetterForProperty
     */
    public function testValidateGetterSetterProperty() {
        list($instance, $trait, $dateA, $dateB) = $this->prepare();

        $trait->validateGetterSetterForProperty($instance, 'a', 'a', 'b', false);
        $trait->validateGetterSetterForProperty($instance, 'b', $dateA, $dateB, false);
        $trait->validateGetterSetterForProperty($instance, 'c', 'c', 'd', true);
    }
}
