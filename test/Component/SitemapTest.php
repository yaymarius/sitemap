<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component;

use Refinery29\Sitemap\Component\Sitemap;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class SitemapTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Sitemap::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsSitemapInterface()
    {
        $sitemap = new Sitemap($this->getFaker()->url);

        $this->assertInstanceOf(SitemapInterface::class, $sitemap);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $lastModified = $faker->dateTime;

        $sitemap = new Sitemap(
            $location,
            $lastModified
        );

        $this->assertSame($location, $sitemap->getLocation());
        $this->assertEquals($lastModified, $sitemap->getLastModified());
        $this->assertNotSame($lastModified, $sitemap->getLastModified());
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $sitemap = new Sitemap($location);

        $this->assertSame($location, $sitemap->getLocation());
        $this->assertNull($sitemap->getLastModified());
    }
}
