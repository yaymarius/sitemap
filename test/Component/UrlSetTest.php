<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component;

use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSet;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class UrlSetTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testDefaults()
    {
        $urlSet = new UrlSet();

        $this->assertInternalType('array', $urlSet->getUrls());
        $this->assertCount(0, $urlSet->getUrls());
    }

    public function testCanAddUrl()
    {
        $url = $this->getUrlMock();

        $urlSet = new UrlSet();
        $urlSet->addUrl($url);

        $this->assertInternalType('array', $urlSet->getUrls());
        $this->assertCount(1, $urlSet->getUrls());
        $this->assertSame($url, $urlSet->getUrls()[0]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrlMock()
    {
        return $this->getMockBuilder(UrlInterface::class)->getMock();
    }
}
