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
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;
use stdClass;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Url::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsUrlInterface()
    {
        $reflectionClass = new ReflectionClass(Url::class);

        $this->assertTrue($reflectionClass->implementsInterface(UrlInterface::class));
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
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $location
     */
    public function testConstructorRejectsInvalidLocation($location)
    {
        $this->setExpectedException(InvalidArgumentException::class);

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
     * @dataProvider providerInvalidChangeFrequency
     *
     * @param mixed $changeFrequency
     */
    public function testWithChangeFrequencyRejectsInvalidChangeFrequency($changeFrequency)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $url->withChangeFrequency($changeFrequency);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidChangeFrequency()
    {
        $faker = $this->getFaker();

        $values = [
            null,
            $faker->boolean(),
            $faker->words,
            $faker->randomNumber(),
            $faker->randomFloat(),
            $faker->sentence(),
            new stdClass(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithChangeFrequencyClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $changeFrequency = $faker->randomElement([
            UrlInterface::CHANGE_FREQUENCY_ALWAYS,
            UrlInterface::CHANGE_FREQUENCY_HOURLY,
            UrlInterface::CHANGE_FREQUENCY_DAILY,
            UrlInterface::CHANGE_FREQUENCY_WEEKLY,
            UrlInterface::CHANGE_FREQUENCY_MONTHLY,
            UrlInterface::CHANGE_FREQUENCY_YEARLY,
            UrlInterface::CHANGE_FREQUENCY_NEVER,
        ]);

        $url = new Url($faker->url);

        $instance = $url->withChangeFrequency($changeFrequency);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($changeFrequency, $instance->changeFrequency());
    }

    /**
     * @dataProvider providerInvalidPriority
     *
     * @param mixed $priority
     */
    public function testWithPriorityRejectsInvalidPriority($priority)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $url = new Url($this->getFaker()->url);

        $url->withPriority($priority);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidPriority()
    {
        $faker = $this->getFaker();

        $values = [
            null,
            $faker->boolean(),
            $faker->words,
            $faker->sentence(),
            UrlInterface::PRIORITY_MIN - 0.1,
            UrlInterface::PRIORITY_MAX + 0.1,
            0.12,
            new stdClass(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithPriorityClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $priority = $faker->randomFloat(
            1,
            0.0,
            1.0
        );

        $url = new Url($faker->url);

        $instance = $url->withPriority($priority);

        $this->assertInstanceOf(Url::class, $instance);
        $this->assertNotSame($url, $instance);
        $this->assertSame($priority, $instance->priority());
    }

    /**
     * @dataProvider providerInvalidImages
     *
     * @param mixed $images
     */
    public function testWithImagesRejectsInvalidValue($images)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withImages($images);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidImages()
    {
        $values = [
            $this->getFaker()->words,
            [
                $this->getImageMock(),
                $this->getImageMock(),
                new stdClass(),
            ],
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withNews($news);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidNews()
    {
        $values = [
            $this->getFaker()->words,
            [
                $this->getNewsMock(),
                $this->getNewsMock(),
                new stdClass(),
            ],
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $url = new Url($faker->url);

        $url->withVideos($videos);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidVideos()
    {
        $values = [
            $this->getFaker()->words,
            [
                $this->getVideoMock(),
                $this->getVideoMock(),
                new stdClass(),
            ],
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
