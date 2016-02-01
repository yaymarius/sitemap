<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocation;
use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class GalleryLocationTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testImplementsInterface()
    {
        $galleryLocation = new GalleryLocation($this->getFaker()->url);

        $this->assertInstanceOf(GalleryLocationInterface::class, $galleryLocation);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $title = $faker->sentence;

        $galleryLocation = new GalleryLocation(
            $location,
            $title
        );

        $this->assertSame($location, $galleryLocation->getLocation());
        $this->assertSame($title, $galleryLocation->getTitle());
    }

    public function testDefaults()
    {
        $galleryLocation = new GalleryLocation($this->getFaker()->url);

        $this->assertNull($galleryLocation->getTitle());
    }
}
