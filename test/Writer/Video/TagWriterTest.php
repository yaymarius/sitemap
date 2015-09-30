<?php

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\TagWriter;
use XMLWriter;

class TagWriterTest extends AbstractTestCase
{
    public function testWriteWithSimpleUploader()
    {
        $content = $this->getFaker()->word;

        $tag = $this->getTagMock($content);

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'video:tag', $content);

        $writer = new TagWriter();

        $writer->write($xmlWriter, $tag);
    }

    /**
     * @param string $content
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TagInterface
     */
    private function getTagMock($content)
    {
        $tag = $this->getMockBuilder(TagInterface::class)->getMock();

        $tag
            ->expects($this->any())
            ->method('getContent')
            ->willReturn($content)
        ;

        return $tag;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
