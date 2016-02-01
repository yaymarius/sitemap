<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Writer;

use DateTime;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Sitemap\Writer\SitemapWriter;
use XMLWriter;

class SitemapWriterTest extends AbstractTestCase
{
    public function testWriteSimpleSitemap()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $sitemap = $this->getSitemapMock($location);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'sitemap');

        $this->expectToWriteElement($xmlWriter, 'loc', $location);

        $this->expectToEndElement($xmlWriter);

        $writer = new SitemapWriter();

        $writer->write($xmlWriter, $sitemap);
    }

    public function testWriteAdvancedSitemap()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $lastModified = $faker->dateTime;

        $sitemap = $this->getSitemapMock(
            $location,
            $lastModified
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'sitemap');

        $this->expectToWriteElement($xmlWriter, 'loc', $location);
        $this->expectToWriteElement($xmlWriter, 'lastmod', $lastModified->format('c'));

        $this->expectToEndElement($xmlWriter);

        $writer = new SitemapWriter();

        $writer->write($xmlWriter, $sitemap);
    }

    /**
     * @param string        $location
     * @param DateTime|null $lastModified
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapInterface
     */
    private function getSitemapMock($location, DateTime $lastModified = null)
    {
        $sitemap = $this->getMockBuilder(SitemapInterface::class)->getMock();

        $sitemap
            ->expects($this->any())
            ->method('getLocation')
            ->willReturn($location)
        ;

        $sitemap
            ->expects($this->any())
            ->method('getLastModified')
            ->willReturn($lastModified)
        ;

        return $sitemap;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
