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
use stdClass;

class UrlSetTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(UrlSet::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    /**
     * @dataProvider providerInvalidUrls
     *
     * @param mixed $urls
     */
    public function testConstructorRejectsInvalidValue($urls)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new UrlSet($urls);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidUrls()
    {
        $values = [
            [
                $this->getUrlMock(),
                $this->getUrlMock(),
                new stdClass(),
            ],
            array_fill(
                0,
                UrlSetInterface::URL_MAX_COUNT + 1,
                $this->getUrlMock()
            ),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
        return $this->getMockBuilder(UrlInterface::class)->getMock();
    }
}
