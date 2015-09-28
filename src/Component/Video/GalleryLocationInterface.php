<?php

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
interface GalleryLocationInterface
{
    /**
     * @return string
     */
    public function getLocation();

    /**
     * @return string|null
     */
    public function getTitle();
}
