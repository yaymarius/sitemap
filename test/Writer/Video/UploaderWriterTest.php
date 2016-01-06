<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\UploaderWriter;
use XMLWriter;

class UploaderWriterTest extends AbstractTestCase
{
    public function testWriteWithSimpleUploader()
    {
        $name = $this->getFaker()->name;

        $uploader = $this->getUploaderMock($name);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:uploader', $name);

        $writer = new UploaderWriter();

        $writer->write($xmlWriter, $uploader);
    }

    public function testWriteWithAdvancedUploader()
    {
        $faker = $this->getFaker();

        $name = $faker->name;
        $info = $faker->url;

        $uploader = $this->getUploaderMock(
            $name,
            $info
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:uploader', $name, [
            'info' => $info,
        ]);

        $writer = new UploaderWriter();

        $writer->write($xmlWriter, $uploader);
    }

    /**
     * @param string      $name
     * @param string|null $info
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|UploaderInterface
     */
    private function getUploaderMock($name, $info = null)
    {
        $uploader = $this->getMockBuilder(UploaderInterface::class)->getMock();

        $uploader
            ->expects($this->any())
            ->method('getName')
            ->willReturn($name)
        ;

        $uploader
            ->expects($this->any())
            ->method('getInfo')
            ->willReturn($info)
        ;

        return $uploader;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
