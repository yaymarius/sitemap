<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer\Video;

use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\PriceWriter;

class PriceWriterTest extends AbstractTestCase
{
    public function testWriteWithSimplePrice()
    {
        $faker = $this->getFaker();

        $currency = $faker->currencyCode;
        $value = $faker->randomFloat(
            2,
            PriceInterface::VALUE_MIN
        );

        $price = $this->getPriceMock(
            $currency,
            $value
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:price', number_format($value, 2), [
            'currency' => $currency,
        ]);

        $writer = new PriceWriter();

        $writer->write($price, $xmlWriter);
    }

    public function testWriteWithAdvancedPrice()
    {
        $faker = $this->getFaker();

        $currency = $faker->currencyCode;
        $value = $faker->randomFloat(
            2,
            PriceInterface::VALUE_MIN
        );
        $type = $faker->randomElement([
            PriceInterface::TYPE_OWN,
            PriceInterface::TYPE_RENT,
        ]);
        $resolution = $faker->randomElement([
            PriceInterface::RESOLUTION_HD,
            PriceInterface::RESOLUTION_SD,
        ]);

        $price = $this->getPriceMock(
            $currency,
            $value,
            $type,
            $resolution
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:price', number_format($value, 2), [
            'currency' => $currency,
            'type' => $type,
            'resolution' => $resolution,
        ]);

        $writer = new PriceWriter();

        $writer->write($price, $xmlWriter);
    }

    /**
     * @param string      $currency
     * @param float       $value
     * @param string|null $type
     * @param string|null $resolution
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|PriceInterface
     */
    private function getPriceMock($currency, $value, $type = null, $resolution = null)
    {
        $price = $this->getMock(PriceInterface::class);

        $price
            ->expects($this->any())
            ->method('currency')
            ->willReturn($currency)
        ;

        $price
            ->expects($this->any())
            ->method('value')
            ->willReturn($value)
        ;

        $price
            ->expects($this->any())
            ->method('type')
            ->willReturn($type)
        ;

        $price
            ->expects($this->any())
            ->method('resolution')
            ->willReturn($resolution)
        ;

        return $price;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMock(\XMLWriter::class);
    }
}
