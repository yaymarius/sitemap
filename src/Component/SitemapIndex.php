<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Assert\Assertion;
use InvalidArgumentException;

final class SitemapIndex implements SitemapIndexInterface
{
    /**
     * @var SitemapInterface[]
     */
    private $sitemaps;

    /**
     * @param SitemapInterface[] $sitemaps
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $sitemaps)
    {
        Assertion::allIsInstanceOf($sitemaps, SitemapInterface::class);

        $locations = array_map(function (SitemapInterface $sitemap) {
            return $sitemap->location();
        }, $sitemaps);

        Assertion::same(array_unique($locations), $locations);

        $this->sitemaps = $sitemaps;
    }

    public function sitemaps()
    {
        return $this->sitemaps;
    }
}
