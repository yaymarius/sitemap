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
        if ($this->hasSitemapWithLocation($sitemap->getLocation())) {
            throw new \InvalidArgumentException(sprintf(
                'Can not add sitemap with duplicate location "%s"',
                $sitemap->getLocation()
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
            if ($sitemap->getLocation() === $location) {
                return true;
            }
        }

        return false;
    }

    public function getSitemaps()
    {
        return $this->sitemaps;
    }
}
