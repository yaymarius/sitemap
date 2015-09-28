<?php

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
interface UploaderInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getInfo();
}
