<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\Price;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Test\Util\TestHelper;

final class PriceTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $this->assertFinal(Price::class);
    }

    public function testImplementsPriceInterface()
    {
        $reflectionClass = new \ReflectionClass(Price::class);

        $this->assertTrue($reflectionClass->implementsInterface(PriceInterface::class));
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $this->assertNull($price->type());
        $this->assertNull($price->resolution());
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidFloat::data()
     *
     * @param mixed $value
     */
    public function testConstructorRejectsInvalidValue($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Price(
            $value,
            $this->getFaker()->currencyCode
        );
    }

    public function testConstructorRejectsTooSmallValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $value = PriceInterface::VALUE_MIN - 0.01;

        $faker = $this->getFaker();

        new Price(
            $value,
            $faker->currencyCode
        );
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $value = $faker->randomFloat(
            2,
            PriceInterface::VALUE_MIN
        );
        $currency = $faker->currencyCode;

        $price = new Price(
            $value,
            $currency
        );

        $this->assertSame($value, $price->value());
        $this->assertSame($currency, $price->currency());
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $type
     */
    public function testWithTypeRejectsInvalidValue($type)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $price->withType($type);
    }

    public function testWithTypeRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $type = $this->getFaker()->sentence();

        $price = new Price(
            $faker->randomFloat(2, PriceInterface::VALUE_MIN),
            $faker->currencyCode
        );

        $price->withType($type);
    }

    /**
     * @dataProvider providerType
     *
     * @param string $type
     */
    public function testWithTypeClonesObjectAndSetsValue($type)
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $instance = $price->withType($type);

        $this->assertInstanceOf(Price::class, $instance);
        $this->assertNotSame($price, $instance);
        $this->assertSame($type, $instance->type());
    }

    /**
     * @return \Generator
     */
    public function providerType()
    {
        $values = [
            PriceInterface::TYPE_OWN,
            PriceInterface::TYPE_RENT,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $resolution
     */
    public function testWithResolutionRejectsInvalidValue($resolution)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $price->withResolution($resolution);
    }

    public function testWithResolutionRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $resolution = $faker->sentence();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $price->withResolution($resolution);
    }

    /**
     * @dataProvider providerResolution
     *
     * @param string $resolution
     */
    public function testWithResolutionClonesObjectAndSetsValue($resolution)
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(
                2,
                PriceInterface::VALUE_MIN
            ),
            $faker->currencyCode
        );

        $instance = $price->withResolution($resolution);

        $this->assertInstanceOf(Price::class, $instance);
        $this->assertNotSame($price, $instance);
        $this->assertSame($resolution, $instance->resolution());
    }

    /**
     * @return \Generator
     */
    public function providerResolution()
    {
        $values = [
            PriceInterface::RESOLUTION_HD,
            PriceInterface::RESOLUTION_SD,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }
}
