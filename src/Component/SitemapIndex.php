<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Assert\Assertion;

final class SitemapIndex implements SitemapIndexInterface
{
    /**
     * @var SitemapInterface[]
     */
    private $sitemaps;

    /**
     * @param SitemapInterface[] $sitemaps
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $sitemaps)
    {
        Assertion::allIsInstanceOf($sitemaps, SitemapInterface::class);

        $this->sitemaps = $sitemaps;
    }

    public function sitemaps()
    {
        return $this->sitemaps;
    }
}
