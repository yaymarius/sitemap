<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Price;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstants()
    {
        $this->assertSame('own', PriceInterface::TYPE_OWN);
        $this->assertSame('rent', PriceInterface::TYPE_RENT);

        $this->assertSame('HD', PriceInterface::RESOLUTION_HD);
        $this->assertSame('SD', PriceInterface::RESOLUTION_SD);
    }

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Price::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsPriceInterface()
    {
        $reflectionClass = new ReflectionClass(Price::class);

        $this->assertTrue($reflectionClass->implementsInterface(PriceInterface::class));
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $this->assertNull($price->type());
        $this->assertNull($price->resolution());
    }

    /**
     * @dataProvider providerInvalidValue
     *
     * @param mixed $value
     */
    public function testConstructorRejectsInvalidValue($value)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Price(
            $value,
            $faker->currencyCode
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidValue()
    {
        $invalidValues = [
            'foo',
            PriceInterface::VALUE_MIN - 0.01,
        ];

        foreach ($invalidValues as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $value = $faker->randomFloat(2, 0.01);
        $currency = $faker->currencyCode;

        $price = new Price(
            $value,
            $currency
        );

        $this->assertSame($value, $price->value());
        $this->assertSame($currency, $price->currency());
    }

    /**
     * @dataProvider providerInvalidType
     *
     * @param mixed $type
     */
    public function testWithTypeRejectsInvalidType($type)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $price->withType($type);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidType()
    {
        $values = [
            null,
            $this->getFaker()->sentence(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithTypeClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $type = $faker->randomElement([
            PriceInterface::TYPE_OWN,
            PriceInterface::TYPE_RENT,
        ]);

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $instance = $price->withType($type);

        $this->assertInstanceOf(Price::class, $instance);
        $this->assertNotSame($price, $instance);
        $this->assertSame($type, $instance->type());
    }

    /**
     * @dataProvider providerInvalidResolution
     *
     * @param mixed $resolution
     */
    public function testWithResolutionRejectsInvalidResolution($resolution)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $price->withResolution($resolution);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidResolution()
    {
        $values = [
            null,
            $this->getFaker()->sentence(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithResolutionClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $resolution = $faker->randomElement([
            PriceInterface::RESOLUTION_HD,
            PriceInterface::RESOLUTION_SD,
        ]);

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $instance = $price->withResolution($resolution);

        $this->assertInstanceOf(Price::class, $instance);
        $this->assertNotSame($price, $instance);
        $this->assertSame($resolution, $instance->resolution());
    }
}
