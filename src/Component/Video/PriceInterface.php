<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
interface PriceInterface
{
    /**
     * Constant for minimum value.
     */
    const VALUE_MIN = 0.01;

    /**
     * Constants for types.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TYPE_OWN = 'own';
    const TYPE_RENT = 'rent';

    /**
     * Constants for resolutions.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const RESOLUTION_HD = 'HD';
    const RESOLUTION_SD = 'SD';

    /**
     * @return float
     */
    public function value();

    /**
     * @return string
     */
    public function currency();

    /**
     * @return string|null
     */
    public function type();

    /**
     * @return string|null
     */
    public function resolution();
}
