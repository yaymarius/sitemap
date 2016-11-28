<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSet;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Test\Util\TestHelper;

final class UrlSetTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(UrlSet::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testConstructorRejectsInvalidValue()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $urls = [
            $this->getUrlMock(),
            $this->getUrlMock(),
            new \stdClass(),
        ];

        new UrlSet($urls);
    }

    public function testConstructorRejectsTooManyValues()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $urls = array_fill(
            0,
            UrlSetInterface::URL_MAX_COUNT + 1,
            $this->getUrlMock()
        );

        new UrlSet($urls);
    }

    public function testConstructorSetsValue()
    {
        $urls = [
            $this->getUrlMock(),
            $this->getUrlMock(),
            $this->getUrlMock(),
        ];

        $urlSet = new UrlSet($urls);

        $this->assertSame($urls, $urlSet->urls());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrlMock()
    {
        return $this->getMock(UrlInterface::class);
    }
}
