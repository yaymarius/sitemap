<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\SitemapIndex;
use Refinery29\Sitemap\Component\SitemapIndexInterface;
use Refinery29\Sitemap\Component\SitemapInterface;
use Refinery29\Test\Util\TestHelper;

final class SitemapIndexTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $this->assertFinal(SitemapIndex::class);
    }

    public function testImplementsSitemapIndexInterface()
    {
        $reflectionClass = new \ReflectionClass(SitemapIndex::class);

        $this->assertTrue($reflectionClass->implementsInterface(SitemapIndexInterface::class));
    }

    /**
     * @dataProvider providerInvalidSitemaps
     *
     * @param mixed $value
     */
    public function testConstructorRejectsInvalidValue($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        new SitemapIndex($value);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidSitemaps()
    {
        $faker = $this->getFaker();

        $values = [
            $faker->words(),
            [
                $this->getSitemapMock(),
                $this->getSitemapMock(),
                new \stdClass(),
            ],
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testConstructorSetsValue()
    {
        $sitemaps = [
            $this->getSitemapMock(),
            $this->getSitemapMock(),
            $this->getSitemapMock(),
        ];

        $sitemapIndex = new SitemapIndex($sitemaps);

        $this->assertSame($sitemaps, $sitemapIndex->sitemaps());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SitemapInterface
     */
    private function getSitemapMock()
    {
        return $this->createMock(SitemapInterface::class);
    }
}
