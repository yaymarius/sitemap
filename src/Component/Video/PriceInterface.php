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
