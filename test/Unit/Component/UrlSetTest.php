<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSet;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class UrlSetTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(UrlSet::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testDefaults()
    {
        $urlSet = new UrlSet();

        $this->assertInternalType('array', $urlSet->urls());
        $this->assertCount(0, $urlSet->urls());
    }

    public function testCanAddUrl()
    {
        $url = $this->getUrlMock();

        $urlSet = new UrlSet();
        $urlSet->addUrl($url);

        $this->assertInternalType('array', $urlSet->urls());
        $this->assertCount(1, $urlSet->urls());
        $this->assertSame($url, $urlSet->urls()[0]);
    }

    public function testCanAddALotOfUrls()
    {
        $urls = array_fill(
            0,
            UrlSetInterface::URL_MAX_COUNT - 1,
            $this->getUrlMock()
        );

        $urlSet = new UrlSet();

        $reflectionProperty = new \ReflectionProperty(UrlSet::class, 'urls');

        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($urlSet, $urls);

        $url = $this->getUrlMock();

        $urlSet->addUrl($url);

        $this->assertInternalType('array', $urlSet->urls());
        $this->assertCount(UrlSetInterface::URL_MAX_COUNT, $urlSet->urls());
        $this->assertContains($url, $urlSet->urls());
    }

    public function testCanNotAddMoreUrlMaxCountUrls()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $urls = array_fill(
            0,
            UrlSetInterface::URL_MAX_COUNT,
            $this->getUrlMock()
        );

        $urlSet = new UrlSet();

        $reflectionProperty = new \ReflectionProperty(UrlSet::class, 'urls');

        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($urlSet, $urls);

        $url = $this->getUrlMock();

        $urlSet->addUrl($url);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrlMock()
    {
        return $this->getMockBuilder(UrlInterface::class)->getMock();
    }
}
