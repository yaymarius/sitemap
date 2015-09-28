<?php

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
interface PlatformInterface
{
    /**
     * @return string
     */
    public function getRelationship();

    /**
     * @return array
     */
    public function getTypes();
}
