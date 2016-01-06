<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Component;

use Refinery29\Sitemap\Component\SitemapIndex;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class SitemapIndexTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testDefaults()
    {
        $index = new SitemapIndex();

        $this->assertInternalType('array', $index->getSitemaps());
        $this->assertCount(0, $index->getSitemaps());
    }

    public function testCanAddSitemap()
    {
        $sitemap = $this->getSitemapMock();

        $index = new SitemapIndex();
        $index->addSitemap($sitemap);

        $this->assertInternalType('array', $index->getSitemaps());
        $this->assertCount(1, $index->getSitemaps());
        $this->assertSame($sitemap, $index->getSitemaps()[0]);
    }

    public function testCanNotAddTwoSitemapsWithSameLocation()
    {
        $this->setExpectedException(\BadMethodCallException::class);

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
        $sitemap = $this->getMockBuilder(SitemapInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $sitemap
            ->expects($this->any())
            ->method('getLocation')
            ->willReturn($location)
        ;

        return $sitemap;
    }
}
