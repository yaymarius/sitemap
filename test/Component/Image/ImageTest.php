<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\Image;

use Refinery29\Sitemap\Component\Image\Image;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testImplementsInterface()
    {
        $location = $this->getFaker()->url;

        $image = new Image($location);

        $this->assertInstanceOf(ImageInterface::class, $image);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $title = $faker->sentence;
        $caption = $faker->sentence;
        $geoLocation = $faker->address;
        $licence = $faker->url;

        $image = new Image(
            $location,
            $title,
            $caption,
            $geoLocation,
            $licence
        );

        $this->assertSame($location, $image->getLocation());
        $this->assertSame($title, $image->getTitle());
        $this->assertSame($caption, $image->getCaption());
        $this->assertSame($geoLocation, $image->getGeoLocation());
        $this->assertSame($licence, $image->getLicence());
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $image = new Image($location);

        $this->assertNull($image->getTitle());
        $this->assertNull($image->getCaption());
        $this->assertNull($image->getGeoLocation());
        $this->assertNull($image->getLicence());
    }
}
