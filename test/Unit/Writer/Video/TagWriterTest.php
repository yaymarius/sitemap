<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Writer\Video;

use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\TagWriter;
use XMLWriter;

class TagWriterTest extends AbstractTestCase
{
    public function testWriteWithSimpleUploader()
    {
        $content = $this->getFaker()->word;

        $tag = $this->getTagMock($content);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:tag', $content);

        $writer = new TagWriter();

        $writer->write($tag, $xmlWriter);
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
            ->method('content')
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
