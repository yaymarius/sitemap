<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use DateTimeInterface;

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
    public function getThumbnailLocation();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string|null
     */
    public function getContentLocation();

    /**
     * @return PlayerLocationInterface|null
     */
    public function getPlayerLocation();

    /**
     * @return GalleryLocationInterface|null
     */
    public function getGalleryLocation();

    /**
     * @return int|null
     */
    public function getDuration();

    /**
     * @return DateTimeInterface|null
     */
    public function getPublicationDate();

    /**
     * @return DateTimeInterface|null
     */
    public function getExpirationDate();

    /**
     * @return float|null
     */
    public function getRating();

    /**
     * @return int|null
     */
    public function getViewCount();

    /**
     * @return string|null
     */
    public function getFamilyFriendly();

    /**
     * @return TagInterface[]
     */
    public function getTags();

    /**
     * @return string|null
     */
    public function getCategory();

    /**
     * @return RestrictionInterface|null
     */
    public function getRestriction();

    /**
     * @return PriceInterface[]
     */
    public function getPrices();

    /**
     * @return string|null
     */
    public function getRequiresSubscription();

    /**
     * @return UploaderInterface|null
     */
    public function getUploader();

    /**
     * @return PlatformInterface|null
     */
    public function getPlatform();

    /**
     * @return string|null
     */
    public function getLive();
}
