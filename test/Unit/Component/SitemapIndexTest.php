<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\SitemapIndex;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class SitemapIndexTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(SitemapIndex::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testDefaults()
    {
        $index = new SitemapIndex();

        $this->assertInternalType('array', $index->sitemaps());
        $this->assertCount(0, $index->sitemaps());
    }

    public function testCanAddSitemap()
    {
        $sitemap = $this->getSitemapMock();

        $index = new SitemapIndex();
        $index->addSitemap($sitemap);

        $this->assertInternalType('array', $index->sitemaps());
        $this->assertCount(1, $index->sitemaps());
        $this->assertSame($sitemap, $index->sitemaps()[0]);
    }

    public function testCanNotAddTwoSitemapsWithSameLocation()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $location = $this->getFaker()->url;

        $sitemap = $this->getSitemapMock($location);
        $anotherSitemap = $this->getSitemapMock($location);

        $index = new SitemapIndex();
        $index->addSitemap($sitemap);

        $index->addSitemap($anotherSitemap);
    }

    /**
     * @param string|null $location
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapInterface
     */
    private function getSitemapMock($location = null)
    {
        $sitemap = $this->getMockBuilder(SitemapInterface::class)->getMock();

        $sitemap
            ->expects($this->any())
            ->method('getLocation')
            ->willReturn($location)
        ;

        return $sitemap;
    }
}
