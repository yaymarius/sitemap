<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Url;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Url::class);

        $this->assertTrue($reflectionClass->isFinal());
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

        $this->assertSame($location, $url->location());
        $this->assertEquals($lastModified, $url->lastModified());
        $this->assertNotSame($lastModified, $url->lastModified());
        $this->assertSame($changeFrequency, $url->changeFrequency());
        $this->assertSame($priority, $url->priority());
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $url = new Url($location);

        $this->assertSame($location, $url->location());
        $this->assertNull($url->lastModified());
        $this->assertNull($url->changeFrequency());
        $this->assertNull($url->priority());
        $this->assertInternalType('array', $url->images());
        $this->assertCount(0, $url->images());
        $this->assertInternalType('array', $url->news());
        $this->assertCount(0, $url->news());
        $this->assertInternalType('array', $url->videos());
        $this->assertCount(0, $url->videos());
    }

    public function testCanAddImages()
    {
        $image = $this->getImageMock();

        $url = new Url($this->getFaker()->url);

        $url->addImage($image);

        $this->assertInternalType('array', $url->images());
        $this->assertCount(1, $url->images());
        $this->assertSame($image, $url->images()[0]);
    }

    public function testCanNotAddMoreThanMaximumNumberOfImages()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $reflection = new ReflectionClass(Url::class);

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

        $this->assertInternalType('array', $url->news());
        $this->assertCount(1, $url->news());
        $this->assertSame($news, $url->news()[0]);
    }

    public function testCanAddVideos()
    {
        $video = $this->getVideoMock();

        $url = new Url($this->getFaker()->url);

        $url->addVideo($video);

        $this->assertInternalType('array', $url->videos());
        $this->assertCount(1, $url->videos());
        $this->assertSame($video, $url->videos()[0]);
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
