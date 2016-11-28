<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Image;

use Refinery29\Sitemap\Component\Image\Image;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Test\Util\TestHelper;

final class ImageTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(Image::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsImageInterface()
    {
        $reflectionClass = new \ReflectionClass(Image::class);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $location
     */
    public function testConstructorRejectsInvalidValue($location)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Image($location);
    }

    public function testConstructorSetsValue()
    {
        $location = $this->getFaker()->url;

        $image = new Image($location);

        $this->assertSame($location, $image->location());
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $title
     */
    public function testWithTitleRejectsInvalidValue($title)
    {
        $this->expectException(\InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withTitle($title);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $title
     */
    public function testWithTitleRejectsEmptyString($title)
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $caption
     */
    public function testWithCaptionRejectsInvalidValue($caption)
    {
        $this->expectException(\InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withCaption($caption);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $caption
     */
    public function testWithCaptionRejectsEmptyString($caption)
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $geoLocation
     */
    public function testWithGeoLocationRejectsInvalidValue($geoLocation)
    {
        $this->expectException(\InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withGeoLocation($geoLocation);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $geoLocation
     */
    public function testWithGeoLocationRejectsBlankString($geoLocation)
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $licence
     */
    public function testWithLicenceRejectsInvalidValue($licence)
    {
        $this->expectException(\InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $image = new Image($location);

        $image->withLicence($licence);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $licence
     */
    public function testWithLicenceRejectsBlankString($licence)
    {
        $this->expectException(\InvalidArgumentException::class);

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
