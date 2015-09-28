<?php

namespace Refinery29\Sitemap\Component;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 */
interface SitemapIndexInterface
{
    /**
     * @param SitemapInterface $sitemap
     */
    public function addSitemap(SitemapInterface $sitemap);

    /**
     * @return SitemapInterface[]
     */
    public function getSitemaps();
}
