<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

final class SitemapIndex implements SitemapIndexInterface
{
    /**
     * @var SitemapInterface[]
     */
    private $sitemaps = [];

    public function addSitemap(SitemapInterface $sitemap)
    {
        if ($this->hasSitemapWithLocation($sitemap->location())) {
            throw new \InvalidArgumentException(sprintf(
                'Can not add sitemap with duplicate location "%s"',
                $sitemap->location()
            ));
        }

        $this->sitemaps[] = $sitemap;
    }

    /**
     * @param string $location
     *
     * @return bool
     */
    private function hasSitemapWithLocation($location)
    {
        foreach ($this->sitemaps as $sitemap) {
            if ($sitemap->location() === $location) {
                return true;
            }
        }

        return false;
    }

    public function sitemaps()
    {
        return $this->sitemaps;
    }
}
