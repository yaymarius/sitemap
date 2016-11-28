<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Url;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Test\Util\TestHelper;

final class UrlTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $this->assertFinal(Url::class);
    }

    public function testImplementsUrlInterface()
    {
        $this->assertImplements(UrlInterface::class, Url::class);
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $url = new Url($location);

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

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $location
     */
    public function testConstructorRejectsInvalidValue($location)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Url($location);
    }

    public function testConstructorSetsValue()
    {
        $location = $this->getFaker()->url;

        $url = new Url($location);

        $this->assertSame($location, $url->location());
    }

    public function testWithLastModifiedClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $lastModified = $faker->dateTime;

        $url = new Url($faker->url);

        $instance = $url->withLastModified($lastModified);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertEquals($lastModified, $instance->lastModified());
        $this->assertNotSame($lastModified, $instance->lastModified());
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $changeFrequency
     */
    public function testWithChangeFrequencyRejectsInvalidValue($changeFrequency)
    {
        $this->expectException(\InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $url->withChangeFrequency($changeFrequency);
    }

    /**
     * @dataProvider providerChangeFrequency
     *
     * @param string $changeFrequency
     */
    public function testWithChangeFrequencyClonesObjectAndSetsValue($changeFrequency)
    {
        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $instance = $url->withChangeFrequency($changeFrequency);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($changeFrequency, $instance->changeFrequency());
    }

    /**
     * @return \Generator
     */
    public function providerChangeFrequency()
    {
        return $this->provideData([
            UrlInterface::CHANGE_FREQUENCY_ALWAYS,
            UrlInterface::CHANGE_FREQUENCY_HOURLY,
            UrlInterface::CHANGE_FREQUENCY_DAILY,
            UrlInterface::CHANGE_FREQUENCY_WEEKLY,
            UrlInterface::CHANGE_FREQUENCY_MONTHLY,
            UrlInterface::CHANGE_FREQUENCY_YEARLY,
            UrlInterface::CHANGE_FREQUENCY_NEVER,
        ]);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidFloat::data()
     *
     * @param mixed $priority
     */
    public function testWithPriorityRejectsInvalidValue($priority)
    {
        $this->expectException(\InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $url->withPriority($priority);
    }

    /**
     * @dataProvider providerOutOfBoundsPriority
     *
     * @param mixed $priority
     */
    public function testWithPriorityRejectsOutOfBoundsValue($priority)
    {
        $this->expectException(\InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $url->withPriority($priority);
    }

    /**
     * @return \Generator
     */
    public function providerOutOfBoundsPriority()
    {
        return $this->provideData([
            UrlInterface::PRIORITY_MIN - 0.1,
            UrlInterface::PRIORITY_MAX + 0.1,
        ]);
    }

    /**
     * @dataProvider providerPriority
     *
     * @param float $priority
     */
    public function testWithPriorityClonesObjectAndSetsValue($priority)
    {
        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $instance = $url->withPriority($priority);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($priority, $instance->priority());
    }

    /**
     * @return \Generator
     */
    public function providerPriority()
    {
        return $this->provideData([
            UrlInterface::PRIORITY_MAX,
            UrlInterface::PRIORITY_MIN,
            $this->getFaker()->randomFloat(
                1,
                UrlInterface::PRIORITY_MIN,
                UrlInterface::PRIORITY_MAX
            ),
        ]);
    }

    /**
     * @dataProvider providerInvalidImages
     *
     * @param mixed $images
     */
    public function testWithImagesRejectsInvalidValue($images)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withImages($images);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidImages()
    {
        return $this->provideData([
            $this->getFaker()->words,
            [
                $this->getImageMock(),
                $this->getImageMock(),
                new \stdClass(),
            ],
        ]);
    }

    public function testWithImagesClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $images = [
            $this->getImageMock(),
            $this->getImageMock(),
            $this->getImageMock(),
        ];

        $url = new Url($faker->url);

        $instance = $url->withImages($images);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($images, $instance->images());
    }

    /**
     * @dataProvider providerInvalidNews
     *
     * @param mixed $news
     */
    public function testWithNewsRejectsInvalidValue($news)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withNews($news);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidNews()
    {
        return $this->provideData([
            $this->getFaker()->words,
            [
                $this->getNewsMock(),
                $this->getNewsMock(),
                new \stdClass(),
            ],
        ]);
    }

    public function testWithNewsClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $news = [
            $this->getNewsMock(),
            $this->getNewsMock(),
            $this->getNewsMock(),
        ];

        $url = new Url($faker->url);

        $instance = $url->withNews($news);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($news, $instance->news());
    }

    /**
     * @dataProvider providerInvalidVideos
     *
     * @param mixed $videos
     */
    public function testWithVideosRejectsInvalidValue($videos)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withVideos($videos);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidVideos()
    {
        return $this->provideData([
            $this->getFaker()->words,
            [
                $this->getVideoMock(),
                $this->getVideoMock(),
                new \stdClass(),
            ],
        ]);
    }

    public function testWithVideosClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $videos = [
            $this->getVideoMock(),
            $this->getVideoMock(),
            $this->getVideoMock(),
        ];

        $url = new Url($faker->url);

        $instance = $url->withVideos($videos);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($videos, $instance->videos());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageInterface
     */
    private function getImageMock()
    {
        return $this->createMock(ImageInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsInterface
     */
    private function getNewsMock()
    {
        return $this->createMock(NewsInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|VideoInterface
     */
    private function getVideoMock()
    {
        return $this->createMock(VideoInterface::class);
    }
}
