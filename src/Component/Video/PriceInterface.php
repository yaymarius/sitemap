<?php

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
interface PriceInterface
{
    /**
     * @return float
     */
    public function getValue();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @return string|null
     */
    public function getResolution();
}
