<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use DateTime;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps
 */
interface VideoInterface
{
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
     * @return DateTime|null
     */
    public function getPublicationDate();

    /**
     * @return DateTime|null
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
