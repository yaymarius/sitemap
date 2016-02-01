<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Writer;

use Refinery29\Sitemap\Component\Image\Image;
use Refinery29\Sitemap\Component\News\News;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSet;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Sitemap\Component\Video\Video;
use Refinery29\Sitemap\Writer\UrlSetWriter;
use Refinery29\Sitemap\Writer\UrlWriter;
use XMLWriter;

class UrlSetWriterTest extends AbstractTestCase
{
    public function testConstructorCreatesRequiredWriter()
    {
        $writer = new UrlSetWriter();

        $this->assertAttributeInstanceOf(UrlWriter::class, 'urlWriter', $writer);
    }

    public function testWriteUrlSet()
    {
        $urls = [
            $this->getUrlMock(),
            $this->getUrlMock(),
            $this->getUrlMock(),
        ];

        $urlSet = $this->getUrlSetMock($urls);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'urlset');

        $this->expectToWriteAttribute($xmlWriter, UrlSet::XML_NAMESPACE_ATTRIBUTE, UrlSet::XML_NAMESPACE_URI);
        $this->expectToWriteAttribute($xmlWriter, Image::XML_NAMESPACE_ATTRIBUTE, Image::XML_NAMESPACE_URI);
        $this->expectToWriteAttribute($xmlWriter, News::XML_NAMESPACE_ATTRIBUTE, News::XML_NAMESPACE_URI);
        $this->expectToWriteAttribute($xmlWriter, Video::XML_NAMESPACE_ATTRIBUTE, Video::XML_NAMESPACE_URI);

        $urlWriter = $this->getUrlWriterMock();

        foreach ($urls as $i => $url) {
            $urlWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($xmlWriter),
                    $this->identicalTo($url)
                )
            ;
        }

        $this->expectToEndElement($xmlWriter);

        $writer = new UrlSetWriter($urlWriter);

        $writer->write($xmlWriter, $urlSet);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrlMock()
    {
        return $this->getMockBuilder(UrlInterface::class)->getMock();
    }

    /**
     * @param UrlInterface[] $urls
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlSetInterface
     */
    private function getUrlSetMock(array $urls = [])
    {
        $urlSet = $this->getMockBuilder(UrlSetInterface::class)->getMock();

        $urlSet
            ->expects($this->any())
            ->method('getUrls')
            ->willReturn($urls)
        ;

        return $urlSet;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlWriter
     */
    private function getUrlWriterMock()
    {
        return $this->getMockBuilder(UrlWriter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
