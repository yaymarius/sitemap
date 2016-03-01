<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer;

use Refinery29\Sitemap\Component\SitemapIndexInterface;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Sitemap\Writer\SitemapIndexWriter;
use Refinery29\Sitemap\Writer\SitemapWriter;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use XMLWriter;

class SitemapIndexWriterTest extends AbstractTestCase
{
    use GeneratorTrait;

    public function testConstructorCreatesRequiredWriter()
    {
        $writer = new SitemapIndexWriter();

        $this->assertAttributeInstanceOf(SitemapWriter::class, 'sitemapWriter', $writer);
    }

    public function testWriteSitemapIndex()
    {
        $output = $this->getFaker()->text();

        $sitemaps = [
            $this->getSitemapMock(),
            $this->getSitemapMock(),
            $this->getSitemapMock(),
        ];

        $sitemapIndex = $this->getSitemapIndexMock($sitemaps);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToOpenMemory($xmlWriter);
        $this->expectToStartDocument($xmlWriter);

        $this->expectToWriteElement($xmlWriter, 'sitemapindex', null, [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
        ]);

        $sitemapWriter = $this->getSitemapWriterMock();

        foreach ($sitemaps as $i => $sitemap) {
            $sitemapWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($sitemap),
                    $this->identicalTo($xmlWriter)
                )
            ;
        }

        $this->expectToEndDocument($xmlWriter);

        $this->expectToOutput($xmlWriter, $output);

        $writer = new SitemapIndexWriter($sitemapWriter);

        $this->assertSame($output, $writer->write($sitemapIndex, $xmlWriter));
    }

    /**
     * @param SitemapInterface[] $sitemaps
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapIndexInterface
     */
    private function getSitemapIndexMock(array $sitemaps = [])
    {
        $sitemapIndex = $this->getMockBuilder(SitemapIndexInterface::class)->getMock();

        $sitemapIndex
            ->expects($this->any())
            ->method('sitemaps')
            ->willReturn($sitemaps)
        ;

        return $sitemapIndex;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapInterface
     */
    private function getSitemapMock()
    {
        return $this->getMockBuilder(SitemapInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapWriter
     */
    private function getSitemapWriterMock()
    {
        return $this->getMockBuilder(SitemapWriter::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
