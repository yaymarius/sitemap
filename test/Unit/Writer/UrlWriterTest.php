<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Writer;

use DateTime;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Sitemap\Writer\Image\ImageWriter;
use Refinery29\Sitemap\Writer\News\NewsWriter;
use Refinery29\Sitemap\Writer\UrlWriter;
use Refinery29\Sitemap\Writer\Video\VideoWriter;
use XMLWriter;

class UrlWriterTest extends AbstractTestCase
{
    public function testWriteSimpleUrl()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $url = $this->getUrlMock($location);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'url');

        $this->expectToWriteElement($xmlWriter, 'loc', $location);

        $this->expectToEndElement($xmlWriter);

        $writer = new UrlWriter(
            $this->getImageWriterMock(),
            $this->getNewsWriterMock(),
            $this->getVideoWriterMock()
        );

        $writer->write($url, $xmlWriter);
    }

    public function testWriteAdvancedUrl()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $lastModified = $faker->dateTime;
        $changeFrequency = $faker->randomElement([
            UrlInterface::CHANGE_FREQUENCY_ALWAYS,
            UrlInterface::CHANGE_FREQUENCY_DAILY,
            UrlInterface::CHANGE_FREQUENCY_HOURLY,
            UrlInterface::CHANGE_FREQUENCY_MONTHLY,
            UrlInterface::CHANGE_FREQUENCY_NEVER,
            UrlInterface::CHANGE_FREQUENCY_WEEKLY,
            UrlInterface::CHANGE_FREQUENCY_YEARLY,
        ]);
        $priority = $faker->randomFloat(2, 0, 1);
        $images = [
            $this->getImageMock(),
            $this->getImageMock(),
            $this->getImageMock(),
        ];
        $news = [
            $this->getNewsMock(),
        ];
        $videos = [
            $this->getVideoMock(),
            $this->getVideoMock(),
            $this->getVideoMock(),
            $this->getVideoMock(),
        ];

        $url = $this->getUrlMock(
            $location,
            $lastModified,
            $changeFrequency,
            $priority,
            $images,
            $news,
            $videos
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'url');

        $this->expectToWriteElement($xmlWriter, 'loc', $location);
        $this->expectToWriteElement($xmlWriter, 'lastmod', $lastModified->format('c'));
        $this->expectToWriteElement($xmlWriter, 'changefreq', $changeFrequency);
        $this->expectToWriteElement($xmlWriter, 'priority', number_format(2, $priority));

        $this->expectToEndElement($xmlWriter);

        $imageWriter = $this->getImageWriterSpy($xmlWriter, $images);
        $newsWriter = $this->getNewsWriterSpy($xmlWriter, $news);
        $videoWriter = $this->getVideoWriterSpy($xmlWriter, $videos);

        $writer = new UrlWriter(
            $imageWriter,
            $newsWriter,
            $videoWriter
        );

        $writer->write($url, $xmlWriter);
    }

    /**
     * @param string           $location
     * @param DateTime|null    $lastModified
     * @param string|null      $changeFrequency
     * @param float|null       $priority
     * @param ImageInterface[] $images
     * @param NewsInterface[]  $news
     * @param VideoInterface[] $videos
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrlMock(
        $location,
        DateTime $lastModified = null,
        $changeFrequency = null,
        $priority = null,
        array $images = [],
        array $news = [],
        array $videos = []
    ) {
        $url = $this->getMockBuilder(UrlInterface::class)->getMock();

        $url
            ->expects($this->any())
            ->method('location')
            ->willReturn($location)
        ;

        $url
            ->expects($this->any())
            ->method('lastModified')
            ->willReturn($lastModified)
        ;

        $url
            ->expects($this->any())
            ->method('changeFrequency')
            ->willReturn($changeFrequency)
        ;

        $url
            ->expects($this->any())
            ->method('priority')
            ->willReturn($priority)
        ;

        $url
            ->expects($this->any())
            ->method('images')
            ->willReturn($images)
        ;

        $url
            ->expects($this->any())
            ->method('news')
            ->willReturn($news)
        ;

        $url
            ->expects($this->any())
            ->method('videos')
            ->willReturn($videos)
        ;

        return $url;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageInterface
     */
    private function getImageMock()
    {
        return $this->getMockBuilder(ImageInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageWriter
     */
    private function getImageWriterMock()
    {
        return $this->getMockBuilder(ImageWriter::class)->getMock();
    }

    /**
     * @param XMLWriter        $xmlWriter
     * @param ImageInterface[] $images
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageWriter
     */
    private function getImageWriterSpy(XMLWriter $xmlWriter, array $images = [])
    {
        $imageWriter = $this->getImageWriterMock();

        foreach ($images as $i => $image) {
            $imageWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($image),
                    $this->identicalTo($xmlWriter)
                )
            ;
        }

        return $imageWriter;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsInterface
     */
    private function getNewsMock()
    {
        return $this->getMockBuilder(NewsInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsWriter
     */
    private function getNewsWriterMock()
    {
        return $this->getMockBuilder(NewsWriter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @param XMLWriter       $xmlWriter
     * @param NewsInterface[] $news
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsWriter
     */
    private function getNewsWriterSpy(XMLWriter $xmlWriter, array $news = [])
    {
        $newsWriter = $this->getNewsWriterMock();

        foreach ($news as $i => $pieceOfNews) {
            $newsWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($pieceOfNews),
                    $this->identicalTo($xmlWriter)
                )
            ;
        }

        return $newsWriter;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|VideoInterface
     */
    private function getVideoMock()
    {
        return $this->getMockBuilder(VideoInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|VideoWriter
     */
    private function getVideoWriterMock()
    {
        return $this->getMockBuilder(VideoWriter::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @param XMLWriter        $xmlWriter
     * @param VideoInterface[] $videos
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|VideoWriter
     */
    private function getVideoWriterSpy(XMLWriter $xmlWriter, array $videos = [])
    {
        $videoWriter = $this->getVideoWriterMock();

        foreach ($videos as $i => $video) {
            $videoWriter
                ->expects($this->at($i))
                ->method('write')
                ->with(
                    $this->identicalTo($video),
                    $this->identicalTo($xmlWriter)
                )
            ;
        }

        return $videoWriter;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
