<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use BadMethodCallException;
use DateTime;
use InvalidArgumentException;

class Video implements VideoInterface
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
     * @var string
     */
    private $thumbnailLocation;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string|null
     */
    private $contentLocation;

    /**
     * @var PlayerLocationInterface|null
     */
    private $playerLocation;

    /**
     * @var GalleryLocationInterface|null
     */
    private $galleryLocation;

    /**
     * @var int|null
     */
    private $duration;

    /**
     * @var DateTime|null
     */
    private $publicationDate;

    /**
     * @var DateTime|null
     */
    private $expirationDate;

    /**
     * @var float|null
     */
    private $rating;

    /**
     * @var int|null
     */
    private $viewCount;

    /**
     * @var string|null
     */
    private $familyFriendly;

    /**
     * @var TagInterface[]
     */
    private $tags = [];

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var RestrictionInterface|null
     */
    private $restriction;

    /**
     * @var PriceInterface[]
     */
    private $prices = [];

    /**
     * @var string|null
     */
    private $requiresSubscription;

    /**
     * @var UploaderInterface|null
     */
    private $uploader;

    /**
     * @var PlatformInterface|null
     */
    private $platform;

    /**
     * @var string|null
     */
    private $live;

    /**
     * @param string                        $thumbnailLocation
     * @param string                        $title
     * @param string                        $description
     * @param string|null                   $contentLocation
     * @param PlayerLocationInterface|null  $playerLocation
     * @param GalleryLocationInterface|null $galleryLocation
     * @param int|null                      $duration
     * @param DateTime|null                 $publicationDate
     * @param DateTime|null                 $expirationDate
     * @param float|null                    $rating
     * @param int|null                      $viewCount
     * @param string|null                   $familyFriendly
     * @param string|null                   $category
     * @param RestrictionInterface|null     $restriction
     * @param string|null                   $requiresSubscription
     * @param UploaderInterface|null        $uploader
     * @param PlatformInterface|null        $platform
     * @param string|null                   $live
     */
    public function __construct(
        $thumbnailLocation,
        $title,
        $description,
        $contentLocation = null,
        PlayerLocationInterface $playerLocation = null,
        GalleryLocationInterface $galleryLocation = null,
        $duration = null,
        DateTime $publicationDate = null,
        DateTime $expirationDate = null,
        $rating = null,
        $viewCount = null,
        $familyFriendly = null,
        $category = null,
        RestrictionInterface $restriction = null,
        $requiresSubscription = null,
        UploaderInterface $uploader = null,
        PlatformInterface $platform = null,
        $live = null
    ) {
        $this->thumbnailLocation = $thumbnailLocation;

        $this->setTitle($title);
        $this->setDescription($description);

        if ($contentLocation === null && $playerLocation === null) {
            throw new InvalidArgumentException(sprintf(
                'At least one of parameters "%s" needs to be specified',
                implode('", "', [
                    'contentLocation',
                    'playerLocation',
                ])
            ));
        }

        $this->contentLocation = $contentLocation;
        $this->playerLocation = $playerLocation;
        $this->galleryLocation = $galleryLocation;

        $this->setDuration($duration);

        $this->publicationDate = $publicationDate;
        $this->expirationDate = $expirationDate;

        $this->setRating($rating);
        $this->setViewCount($viewCount);
        $this->setFamilyFriendly($familyFriendly);
        $this->setCategory($category);

        $this->restriction = $restriction;

        $this->setRequiresSubscription($requiresSubscription);

        $this->uploader = $uploader;
        $this->platform = $platform;

        $this->setLive($live);
    }

    public function getThumbnailLocation()
    {
        return $this->thumbnailLocation;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        if (!is_string($title) || mb_strlen($title) > self::TITLE_MAX_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Parameter "%s" needs to be specified as a string not longer than "%s" characters',
                'title',
                self::TITLE_MAX_LENGTH
            ));
        }

        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    private function setDescription($description)
    {
        if (!is_string($description) || mb_strlen($description) > self::DESCRIPTION_MAX_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as a string not longer than "%s" characters',
                'description',
                self::DESCRIPTION_MAX_LENGTH
            ));
        }

        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getContentLocation()
    {
        return $this->contentLocation;
    }

    public function getPlayerLocation()
    {
        return $this->playerLocation;
    }

    public function getGalleryLocation()
    {
        return $this->galleryLocation;
    }

    /**
     * @param int|null $duration
     */
    private function setDuration($duration = null)
    {
        if ($duration === null) {
            return;
        }

        if (!is_int($duration) || $duration <= self::DURATION_LOWER_LIMIT || $duration >= self::DURATION_UPPER_LIMIT) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as an integer greater than "%s" and smaller than "%s"',
                'duration',
                self::DURATION_LOWER_LIMIT,
                self::DURATION_UPPER_LIMIT
            ));
        }

        $this->duration = $duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getPublicationDate()
    {
        if ($this->publicationDate === null) {
            return;
        }

        return clone $this->publicationDate;
    }

    public function getExpirationDate()
    {
        if ($this->expirationDate === null) {
            return;
        }

        return clone $this->expirationDate;
    }

    /**
     * @param float|null $rating
     */
    private function setRating($rating = null)
    {
        if ($rating === null) {
            return;
        }

        if (!is_numeric($rating) || $rating < self::RATING_MIN || $rating > self::RATING_MAX) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as a number not smaller than "%s" and not greater than "%s"',
                'rating',
                self::RATING_MIN,
                self::RATING_MAX
            ));
        }

        $this->rating = $rating;
    }

    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int|null $viewCount
     */
    private function setViewCount($viewCount = null)
    {
        if ($viewCount === null) {
            return;
        }

        if (!is_int($viewCount) || $viewCount < 0) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as an integer not less than "%s"',
                'viewCount',
                0
            ));
        }

        $this->viewCount = $viewCount;
    }

    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param string|null $familyFriendly
     */
    private function setFamilyFriendly($familyFriendly = null)
    {
        if ($familyFriendly === null) {
            return;
        }

        if ($familyFriendly !== self::FAMILY_FRIENDLY_NO) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as "%s"',
                'familyFriendly',
                self::FAMILY_FRIENDLY_NO
            ));
        }

        $this->familyFriendly = $familyFriendly;
    }

    public function getFamilyFriendly()
    {
        return $this->familyFriendly;
    }

    /**
     * @param TagInterface $tag
     */
    public function addTag(TagInterface $tag)
    {
        if (count($this->tags) === self::TAG_MAX_COUNT) {
            throw new BadMethodCallException(sprintf(
                'Can not add more than %s tags',
                self::TAG_MAX_COUNT
            ));
        }

        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string|null $category
     */
    private function setCategory($category = null)
    {
        if ($category === null) {
            return;
        }

        if (!is_string($category) || mb_strlen($category) > self::CATEGORY_MAX_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as a string not longer than "%s" characters',
                'category',
                self::CATEGORY_MAX_LENGTH
            ));
        }

        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getRestriction()
    {
        return $this->restriction;
    }

    /**
     * @param PriceInterface $price
     */
    public function addPrice(PriceInterface $price)
    {
        $this->prices[] = $price;
    }

    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param string|null $requiresSubscription
     */
    private function setRequiresSubscription($requiresSubscription = null)
    {
        if ($requiresSubscription === null) {
            return;
        }

        $allowedValues = [
            self::REQUIRES_SUBSCRIPTION_NO,
            self::REQUIRES_SUBSCRIPTION_YES,
        ];

        if (!is_string($requiresSubscription) || !in_array($requiresSubscription, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as one of "%s"',
                'requiresSubscription',
                implode('", "', $allowedValues)
            ));
        }

        $this->requiresSubscription = $requiresSubscription;
    }

    public function getRequiresSubscription()
    {
        return $this->requiresSubscription;
    }

    public function getUploader()
    {
        return $this->uploader;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string|null $live
     */
    private function setLive($live = null)
    {
        if ($live === null) {
            return;
        }

        $allowedValues = [
            self::LIVE_NO,
            self::LIVE_YES,
        ];

        if (!is_string($live) || !in_array($live, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as one of "%s"',
                'live',
                implode('", "', $allowedValues)
            ));
        }

        $this->live = $live;
    }

    public function getLive()
    {
        return $this->live;
    }
}
