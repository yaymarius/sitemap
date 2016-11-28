<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\Sitemap;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Test\Util\TestHelper;

final class SitemapTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(Sitemap::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsSitemapInterface()
    {
        $reflectionClass = new \ReflectionClass(Sitemap::class);

        $this->assertTrue($reflectionClass->implementsInterface(SitemapInterface::class));
    }

    public function testDefaults()
    {
        $location = $this->getFaker()->url;

        $sitemap = new Sitemap($location);

        $this->assertSame($location, $sitemap->location());
        $this->assertNull($sitemap->lastModified());
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $location
     */
    public function testConstructorRejectsInvalidValue($location)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new Sitemap($location);
    }

    public function testConstructorSetsLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $sitemap = new Sitemap($location);

        $this->assertSame($location, $sitemap->location());
    }

    public function testWithLastModifiedClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $lastModified = $faker->dateTime;

        $sitemap = new Sitemap($faker->url);

        $instance = $sitemap->withLastModified($lastModified);

        $this->assertInstanceOf(Sitemap::class, $instance);
        $this->assertNotSame($sitemap, $instance);
        $this->assertEquals($lastModified, $instance->lastModified());
        $this->assertNotSame($lastModified, $instance->lastModified());
    }
}
