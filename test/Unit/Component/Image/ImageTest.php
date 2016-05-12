<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Image;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Image\Image;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Image::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsImageInterface()
    {
        $reflectionClass = new ReflectionClass(Image::class);

        $this->assertTrue($reflectionClass->implementsInterface(ImageInterface::class));
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $image = new Image($location);

        $this->assertNull($image->title());
        $this->assertNull($image->caption());
        $this->assertNull($image->geoLocation());
        $this->assertNull($image->licence());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $location
     */
    public function testConstructorRejectsInvalidValue($location)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Image($location);
    }

    public function testConstructorSetsValue()
    {
        $location = $this->getFaker()->url;

        $image = new Image($location);

        $this->assertSame($location, $image->location());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $title
     */
    public function testWithTitleRejectsInvalidValue($title)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withTitle($title);
    }

    public function testWithTitleClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $title = $faker->sentence;

        $image = new Image($faker->url);

        $instance = $image->withTitle($title);

        $this->assertInstanceOf(Image::class, $instance);
        $this->assertNotSame($image, $instance);
        $this->assertSame($title, $instance->title());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $caption
     */
    public function testWithCaptionRejectsInvalidValue($caption)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withCaption($caption);
    }

    public function testWithCaptionClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $caption = $faker->sentence;

        $image = new Image($faker->url);

        $instance = $image->withCaption($caption);

        $this->assertInstanceOf(Image::class, $instance);
        $this->assertNotSame($image, $instance);
        $this->assertSame($caption, $instance->caption());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $geoLocation
     */
    public function testWithGeoLocationRejectsInvalidValue($geoLocation)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withGeoLocation($geoLocation);
    }

    public function testWithGeoLocationClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $geoLocation = $faker->address;

        $image = new Image($faker->url);

        $instance = $image->withGeoLocation($geoLocation);

        $this->assertInstanceOf(Image::class, $instance);
        $this->assertNotSame($image, $instance);
        $this->assertSame($geoLocation, $instance->geoLocation());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $licence
     */
    public function testWithLicenceRejectsInvalidValue($licence)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withLicence($licence);
    }

    public function testWithLicenceClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $licence = $faker->address;

        $image = new Image($faker->url);

        $instance = $image->withLicence($licence);

        $this->assertInstanceOf(Image::class, $instance);
        $this->assertNotSame($image, $instance);
        $this->assertSame($licence, $instance->licence());
    }
}
