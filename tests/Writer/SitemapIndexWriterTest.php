<?php

namespace Refinery29\Sitemap\Test\Writer;

use Refinery29\Sitemap\Component\SitemapIndexInterface;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Sitemap\Writer\SitemapIndexWriter;
use Refinery29\Sitemap\Writer\SitemapWriter;
use XMLWriter;

class SitemapIndexWriterTest extends AbstractTestCase
{
    public function testConstructorCreatesRequiredWriter()
    {
        $writer = new SitemapIndexWriter();

        $this->assertAttributeInstanceOf(SitemapWriter::class, 'sitemapWriter', $writer);
    }

    public function testWriteSitemapIndex()
    {
        $sitemaps = [
            $this->getSitemapMock(),
            $this->getSitemapMock(),
            $this->getSitemapMock(),
        ];

        $sitemapIndex = $this->getSitemapIndexMock($sitemaps);

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'sitemapindex', null, [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
        ]);

        $sitemapWriter = $this->getSitemapWriterMock();

        foreach ($sitemaps as $i => $sitemap) {
            $sitemapWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($xmlWriter),
                    $this->identicalTo($sitemap)
                )
            ;
        }

        $writer = new SitemapIndexWriter($sitemapWriter);

        $writer->write($xmlWriter, $sitemapIndex);
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
            ->method('getSitemaps')
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
