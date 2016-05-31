<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps
 */
interface VideoInterface
{
    /**
     * Constants for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns:video';
    const XML_NAMESPACE_URI = 'http://www.google.com/schemas/sitemap-video/1.1';

    /**
     * Constant for maximum title length.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TITLE_MAX_LENGTH = 100;

    /**
     * Constant for maximum description length.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const DESCRIPTION_MAX_LENGTH = 2048;

    /**
     * Constants for duration limits.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const DURATION_LOWER_LIMIT = 0;
    const DURATION_UPPER_LIMIT = 28800;

    /**
     * Constants for rating minimum and maximum values.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const RATING_MIN = 0.0;
    const RATING_MAX = 5.0;

    /**
     * Constant for view count minimum value.
     */
    const VIEW_COUNT_MIN = 0;

    /**
     * Constants for subscription requirement.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const REQUIRES_SUBSCRIPTION_NO = 'no';
    const REQUIRES_SUBSCRIPTION_YES = 'yes';

    /**
     * Constants for family friendliness.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const FAMILY_FRIENDLY_NO = 'no';

    /**
     * Constants for category maximum length.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const CATEGORY_MAX_LENGTH = 256;

    /**
     * Constants for maximum number of allowed tags.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TAG_MAX_COUNT = 32;

    /**
     * Constants for live.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const LIVE_YES = 'yes';
    const LIVE_NO = 'no';

    /**
     * @return string
     */
    public function thumbnailLocation();

    /**
     * @return string
     */
    public function title();

    /**
     * @return string
     */
    public function description();

    /**
     * @return string|null
     */
    public function contentLocation();

    /**
     * @return PlayerLocationInterface|null
     */
    public function playerLocation();

    /**
     * @return GalleryLocationInterface|null
     */
    public function galleryLocation();

    /**
     * @return int|null
     */
    public function duration();

    /**
     * @return \DateTimeInterface|null
     */
    public function publicationDate();

    /**
     * @return \DateTimeInterface|null
     */
    public function expirationDate();

    /**
     * @return float|null
     */
    public function rating();

    /**
     * @return int|null
     */
    public function viewCount();

    /**
     * @return string|null
     */
    public function familyFriendly();

    /**
     * @return TagInterface[]
     */
    public function tags();

    /**
     * @return string|null
     */
    public function category();

    /**
     * @return RestrictionInterface|null
     */
    public function restriction();

    /**
     * @return PriceInterface[]
     */
    public function prices();

    /**
     * @return string|null
     */
    public function requiresSubscription();

    /**
     * @return UploaderInterface|null
     */
    public function uploader();

    /**
     * @return PlatformInterface|null
     */
    public function platform();

    /**
     * @return string|null
     */
    public function live();
}
