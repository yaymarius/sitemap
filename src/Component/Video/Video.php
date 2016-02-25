<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;
use DateTimeInterface;

final class Video implements VideoInterface
{
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
     * @var DateTimeInterface|null
     */
    private $publicationDate;

    /**
     * @var DateTimeInterface|null
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
     * @param DateTimeInterface|null        $publicationDate
     * @param DateTimeInterface|null        $expirationDate
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
        DateTimeInterface $publicationDate = null,
        DateTimeInterface $expirationDate = null,
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

        Assertion::false($contentLocation === null && $playerLocation === null, sprintf(
            'At least one of parameters "%s" needs to be specified',
            implode('", "', [
                'contentLocation',
                'playerLocation',
            ])
        ));

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

    public function thumbnailLocation()
    {
        return $this->thumbnailLocation;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        Assertion::maxLength($title, VideoInterface::TITLE_MAX_LENGTH);

        $this->title = $title;
    }

    public function title()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    private function setDescription($description)
    {
        Assertion::maxLength($description, VideoInterface::DESCRIPTION_MAX_LENGTH);

        $this->description = $description;
    }

    public function description()
    {
        return $this->description;
    }

    public function contentLocation()
    {
        return $this->contentLocation;
    }

    public function playerLocation()
    {
        return $this->playerLocation;
    }

    public function galleryLocation()
    {
        return $this->galleryLocation;
    }

    /**
     * @param int|null $duration
     */
    private function setDuration($duration = null)
    {
        Assertion::nullOrInteger($duration);

        if ($duration !== null) {
            Assertion::greaterThan($duration, VideoInterface::DURATION_LOWER_LIMIT);
            Assertion::lessThan($duration, VideoInterface::DURATION_UPPER_LIMIT);
        }

        $this->duration = $duration;
    }

    public function duration()
    {
        return $this->duration;
    }

    public function publicationDate()
    {
        if ($this->publicationDate === null) {
            return;
        }

        return clone $this->publicationDate;
    }

    public function expirationDate()
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
        Assertion::nullOrNumeric($rating);

        if ($rating !== null) {
            Assertion::greaterOrEqualThan($rating, VideoInterface::RATING_MIN);
            Assertion::lessOrEqualThan($rating, VideoInterface::RATING_MAX);
        }

        $this->rating = $rating;
    }

    public function rating()
    {
        return $this->rating;
    }

    /**
     * @param int|null $viewCount
     */
    private function setViewCount($viewCount = null)
    {
        Assertion::nullOrInteger($viewCount);

        if ($viewCount !== null) {
            Assertion::greaterOrEqualThan($viewCount, 0);
        }

        $this->viewCount = $viewCount;
    }

    public function viewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param string|null $familyFriendly
     */
    private function setFamilyFriendly($familyFriendly = null)
    {
        $choices = [
            VideoInterface::FAMILY_FRIENDLY_NO,
        ];

        Assertion::nullOrChoice($familyFriendly, $choices);

        $this->familyFriendly = $familyFriendly;
    }

    public function familyFriendly()
    {
        return $this->familyFriendly;
    }

    public function addTag(TagInterface $tag)
    {
        Assertion::lessThan(count($this->tags), VideoInterface::TAG_MAX_COUNT);

        $this->tags[] = $tag;
    }

    public function tags()
    {
        return $this->tags;
    }

    /**
     * @param string|null $category
     */
    private function setCategory($category = null)
    {
        Assertion::nullOrString($category);

        if ($category !== null) {
            Assertion::maxLength($category, VideoInterface::CATEGORY_MAX_LENGTH);
        }

        $this->category = $category;
    }

    public function category()
    {
        return $this->category;
    }

    public function restriction()
    {
        return $this->restriction;
    }

    public function addPrice(PriceInterface $price)
    {
        $this->prices[] = $price;
    }

    public function prices()
    {
        return $this->prices;
    }

    /**
     * @param string|null $requiresSubscription
     */
    private function setRequiresSubscription($requiresSubscription = null)
    {
        $choices = [
            VideoInterface::REQUIRES_SUBSCRIPTION_NO,
            VideoInterface::REQUIRES_SUBSCRIPTION_YES,
        ];

        Assertion::nullOrChoice($requiresSubscription, $choices);

        $this->requiresSubscription = $requiresSubscription;
    }

    public function requiresSubscription()
    {
        return $this->requiresSubscription;
    }

    public function uploader()
    {
        return $this->uploader;
    }

    public function platform()
    {
        return $this->platform;
    }

    /**
     * @param string|null $live
     */
    private function setLive($live = null)
    {
        $choices = [
            VideoInterface::LIVE_NO,
            VideoInterface::LIVE_YES,
        ];

        Assertion::nullOrChoice($live, $choices);

        $this->live = $live;
    }

    public function live()
    {
        return $this->live;
    }
}
