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
interface PlatformInterface
{
    /**
     * Constants for types.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TYPE_MOBILE = 'mobile';
    const TYPE_TV = 'tv';
    const TYPE_WEB = 'web';

    /**
     * Constants for resolutions.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const RELATIONSHIP_ALLOW = 'allow';
    const RELATIONSHIP_DENY = 'deny';

    /**
     * @return string
     */
    public function relationship();

    /**
     * @return array
     */
    public function types();
}
