<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

use Assert\Assertion;
use DateTimeInterface;
use InvalidArgumentException;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

final class Url implements UrlInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $lastModified;

    /**
     * @var string|null
     */
    private $changeFrequency;

    /**
     * @var string|null
     */
    private $priority;

    /**
     * @var ImageInterface[]
     */
    private $images = [];

    /**
     * @var NewsInterface[]
     */
    private $news = [];

    /**
     * @var VideoInterface[]
     */
    private $videos = [];

    /**
     * @param string                 $location
     * @param DateTimeInterface|null $lastModified
     * @param string|null            $changeFrequency
     * @param string|null            $priority
     */
    public function __construct($location, DateTimeInterface $lastModified = null, $changeFrequency = null, $priority = null)
    {
        $this->location = $location;
        $this->lastModified = $lastModified;
        $this->changeFrequency = $changeFrequency;
        $this->priority = $priority;
    }

    public function location()
    {
        return $this->location;
    }

    public function lastModified()
    {
        return $this->lastModified;
    }

    public function changeFrequency()
    {
        return $this->changeFrequency;
    }

    public function priority()
    {
        return $this->priority;
    }

    public function images()
    {
        return $this->images;
    }

    public function news()
    {
        return $this->news;
    }

    public function videos()
    {
        return $this->videos;
    }

    /**
     * @param DateTimeInterface $lastModified
     *
     * @return static
     */
    public function withLastModified(DateTimeInterface $lastModified)
    {
        $instance = clone $this;

        $instance->lastModified = clone $lastModified;

        return $instance;
    }

    /**
     * @param string $changeFrequency
     *
     * @return static
     */
    public function withChangeFrequency($changeFrequency)
    {
        $instance = clone $this;

        $instance->changeFrequency = $changeFrequency;

        return $instance;
    }

    /**
     * @param string $priority
     *
     * @return static
     */
    public function withPriority($priority)
    {
        $instance = clone $this;

        $instance->priority = $priority;

        return $instance;
    }

    /**
     * @param ImageInterface[] $images
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function withImages(array $images)
    {
        Assertion::allIsInstanceOf($images, ImageInterface::class);
        Assertion::lessOrEqualThan(count($this->images), UrlInterface::IMAGE_MAX_COUNT);

        $instance = clone $this;

        $instance->images = $images;

        return $instance;
    }

    /**
     * @param NewsInterface[] $news
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function withNews(array $news)
    {
        Assertion::allIsInstanceOf($news, NewsInterface::class);

        $instance = clone $this;

        $instance->news = $news;

        return $instance;
    }

    /**
     * @param VideoInterface[] $videos
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function withVideos(array $videos)
    {
        Assertion::allIsInstanceOf($videos, VideoInterface::class);

        $instance = clone $this;

        $instance->videos = $videos;

        return $instance;
    }
}
