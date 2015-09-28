<?php

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\Price;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\PriceWriter;
use XMLWriter;

class PriceWriterTest extends AbstractTestCase
{
    public function testWriteWithSimplePrice()
    {
        $faker = $this->getFaker();

        $currency = $faker->currencyCode;
        $value = $faker->randomFloat(2, 0.01);

        $price = $this->getPriceMock(
            $currency,
            $value
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'video:price', number_format($value, 2), [
            'currency' => $currency,
        ]);

        $writer = new PriceWriter();

        $writer->write($xmlWriter, $price);
    }

    public function testWriteWithAdvancedPrice()
    {
        $faker = $this->getFaker();

        $currency = $faker->currencyCode;
        $value = $faker->randomFloat(2, 0.01);
        $type = $faker->randomElement([
            Price::TYPE_OWN,
            Price::TYPE_RENT,
        ]);
        $resolution = $faker->randomElement([
            Price::RESOLUTION_HD,
            Price::RESOLUTION_SD,
        ]);

        $price = $this->getPriceMock(
            $currency,
            $value,
            $type,
            $resolution
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'video:price', number_format($value, 2), [
            'currency' => $currency,
            'type' => $type,
            'resolution' => $resolution,
        ]);

        $writer = new PriceWriter();

        $writer->write($xmlWriter, $price);
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
        $price = $this->getMockBuilder(PriceInterface::class)->getMock();

        $price
            ->expects($this->any())
            ->method('getCurrency')
            ->willReturn($currency)
        ;

        $price
            ->expects($this->any())
            ->method('getValue')
            ->willReturn($value)
        ;

        $price
            ->expects($this->any())
            ->method('getType')
            ->willReturn($type)
        ;

        $price
            ->expects($this->any())
            ->method('getResolution')
            ->willReturn($resolution)
        ;

        return $price;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
