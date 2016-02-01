<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component;

use BadMethodCallException;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Url;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testConstants()
    {
        $this->assertSame('always', Url::CHANGE_FREQUENCY_ALWAYS);
        $this->assertSame('hourly', Url::CHANGE_FREQUENCY_HOURLY);
        $this->assertSame('daily', Url::CHANGE_FREQUENCY_DAILY);
        $this->assertSame('weekly', Url::CHANGE_FREQUENCY_WEEKLY);
        $this->assertSame('monthly', Url::CHANGE_FREQUENCY_MONTHLY);
        $this->assertSame('yearly', Url::CHANGE_FREQUENCY_YEARLY);
        $this->assertSame('never', Url::CHANGE_FREQUENCY_NEVER);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $lastModified = $faker->dateTime;
        $changeFrequency = $faker->word;
        $priority = $faker->randomFloat(1, 0, 1);

        $url = new Url(
            $location,
            $lastModified,
            $changeFrequency,
            $priority
        );

        $this->assertSame($location, $url->getLocation());
        $this->assertEquals($lastModified, $url->getLastModified());
        $this->assertNotSame($lastModified, $url->getLastModified());
        $this->assertSame($changeFrequency, $url->getChangeFrequency());
        $this->assertSame($priority, $url->getPriority());
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $url = new Url($location);

        $this->assertSame($location, $url->getLocation());
        $this->assertNull($url->getLastModified());
        $this->assertNull($url->getChangeFrequency());
        $this->assertNull($url->getPriority());
        $this->assertInternalType('array', $url->getImages());
        $this->assertCount(0, $url->getImages());
        $this->assertInternalType('array', $url->getNews());
        $this->assertCount(0, $url->getNews());
        $this->assertInternalType('array', $url->getVideos());
        $this->assertCount(0, $url->getVideos());
    }

    public function testCanAddImages()
    {
        $image = $this->getImageMock();

        $url = new Url($this->getFaker()->url);

        $url->addImage($image);

        $this->assertInternalType('array', $url->getImages());
        $this->assertCount(1, $url->getImages());
        $this->assertSame($image, $url->getImages()[0]);
    }

    public function testCanNotAddMoreThanMaximumNumberOfImages()
    {
        $this->setExpectedException(BadMethodCallException::class);

        $url = new Url($this->getFaker()->url);

        $reflection = new \ReflectionClass(Url::class);

        $property = $reflection->getProperty('images');
        $property->setAccessible(true);

        $property->setValue($url, range(1, 1000));

        $url->addImage($this->getImageMock());
    }

    public function testCanAddNews()
    {
        $news = $this->getNewsMock();

        $url = new Url($this->getFaker()->url);

        $url->addNews($news);

        $this->assertInternalType('array', $url->getNews());
        $this->assertCount(1, $url->getNews());
        $this->assertSame($news, $url->getNews()[0]);
    }

    public function testCanAddVideos()
    {
        $video = $this->getVideoMock();

        $url = new Url($this->getFaker()->url);

        $url->addVideo($video);

        $this->assertInternalType('array', $url->getVideos());
        $this->assertCount(1, $url->getVideos());
        $this->assertSame($video, $url->getVideos()[0]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageInterface
     */
    private function getImageMock()
    {
        return $this->getMockBuilder(ImageInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsInterface
     */
    private function getNewsMock()
    {
        return $this->getMockBuilder(NewsInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|VideoInterface
     */
    private function getVideoMock()
    {
        return $this->getMockBuilder(VideoInterface::class)->getMock();
    }
}
