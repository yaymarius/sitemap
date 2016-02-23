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

    public function getLocation()
    {
        return $this->location;
    }

    public function getLastModified()
    {
        if ($this->lastModified === null) {
            return;
        }

        return clone $this->lastModified;
    }

    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param ImageInterface $image
     */
    public function addImage(ImageInterface $image)
    {
        Assertion::lessThan(count($this->images), UrlInterface::IMAGE_MAX_COUNT);

        $this->images[] = $image;
    }

    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param NewsInterface $news
     */
    public function addNews(NewsInterface $news)
    {
        $this->news[] = $news;
    }

    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param VideoInterface $video
     */
    public function addVideo(VideoInterface $video)
    {
        $this->videos[] = $video;
    }

    public function getVideos()
    {
        return $this->videos;
    }
}
