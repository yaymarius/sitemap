<?php

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\GalleryLocationWriter;
use XMLWriter;

class GalleryLocationWriterTest extends AbstractTestCase
{
    public function testWriteSimpleGalleryLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $galleryLocation = $this->getGalleryLocationMock($location);

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'video:gallery_loc', $location);

        $writer = new GalleryLocationWriter();

        $writer->write($xmlWriter, $galleryLocation);
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

        $this->writesElement($xmlWriter, 'video:gallery_loc', $location, [
            'title' => $title,
        ]);

        $writer = new GalleryLocationWriter();

        $writer->write($xmlWriter, $galleryLocation);
    }

    /**
     * @param string      $location
     * @param string|null $title
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|GalleryLocationInterface
     */
    private function getGalleryLocationMock($location, $title = null)
    {
        $galleryLocation = $this->getMockBuilder(GalleryLocationInterface::class)->getMock();

        $galleryLocation
            ->expects($this->any())
            ->method('getLocation')
            ->willReturn($location)
        ;

        $galleryLocation
            ->expects($this->any())
            ->method('getTitle')
            ->willReturn($title)
        ;

        return $galleryLocation;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
