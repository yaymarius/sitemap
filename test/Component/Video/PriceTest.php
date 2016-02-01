<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Price;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testConstants()
    {
        $this->assertSame('own', Price::TYPE_OWN);
        $this->assertSame('rent', Price::TYPE_RENT);

        $this->assertSame('HD', Price::RESOLUTION_HD);
        $this->assertSame('SD', Price::RESOLUTION_SD);
    }

    public function testImplementsInterface()
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $this->assertInstanceOf(PriceInterface::class, $price);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $value = $faker->randomFloat(2, 0.01);
        $currency = $faker->currencyCode;
        $type = $faker->randomElement([
            Price::TYPE_OWN,
            Price::TYPE_RENT,
        ]);
        $resolution = $faker->randomElement([
            Price::RESOLUTION_HD,
            Price::RESOLUTION_SD,
        ]);

        $price = new Price(
            $value,
            $currency,
            $type,
            $resolution
        );

        $this->assertSame($value, $price->getValue());
        $this->assertSame($currency, $price->getCurrency());
        $this->assertSame($type, $price->getType());
        $this->assertSame($resolution, $price->getResolution());
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $price = new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode
        );

        $this->assertNull($price->getType());
        $this->assertNull($price->getResolution());
    }

    public function testInvalidTypeIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode,
            'foobarbaz'
        );
    }

    /**
     * @dataProvider providerInvalidValueIsRejected
     *
     * @param mixed $value
     */
    public function testInvalidValueIsRejected($value)
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
    public function providerInvalidValueIsRejected()
    {
        $invalidValues = [
            'foo',
            Price::VALUE_MIN - 0.01,
        ];

        foreach ($invalidValues as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testInvalidResolutionIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Price(
            $faker->randomFloat(2, 0.01),
            $faker->currencyCode,
            $faker->randomElement([
                Price::TYPE_OWN,
                Price::TYPE_RENT,
            ]),
            'foobarbaz'

        );
    }
}
