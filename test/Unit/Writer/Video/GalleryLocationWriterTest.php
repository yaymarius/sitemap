<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\GalleryLocationWriter;

class GalleryLocationWriterTest extends AbstractTestCase
{
    public function testWriteSimpleGalleryLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $galleryLocation = $this->getGalleryLocationMock($location);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:gallery_loc', $location);

        $writer = new GalleryLocationWriter();

        $writer->write($galleryLocation, $xmlWriter);
    }

    public function testWriteAdvancedGalleryLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $title = $faker->sentence;

        $galleryLocation = $this->getGalleryLocationMock(
            $location,
            $title
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:gallery_loc', $location, [
            'title' => $title,
        ]);

        $writer = new GalleryLocationWriter();

        $writer->write($galleryLocation, $xmlWriter);
    }

    /**
     * @param string      $location
     * @param string|null $title
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|GalleryLocationInterface
     */
    private function getGalleryLocationMock($location, $title = null)
    {
        $galleryLocation = $this->getMock(GalleryLocationInterface::class);

        $galleryLocation
            ->expects($this->any())
            ->method('location')
            ->willReturn($location);

        $galleryLocation
            ->expects($this->any())
            ->method('title')
            ->willReturn($title);

        return $galleryLocation;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMock(\XMLWriter::class);
    }
}
