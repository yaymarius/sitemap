<?php

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
            throw new \BadMethodCallException(sprintf(
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
