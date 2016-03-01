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
interface PlayerLocationInterface
{
    /**
     * Constants for allow embedding values.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const ALLOW_EMBED_YES = 'yes';
    const ALLOW_EMBED_NO = 'no';

    /**
     * @return string
     */
    public function location();

    /**
     * @return string|null
     */
    public function allowEmbed();

    /**
     * @return string|null
     */
    public function autoPlay();
}
