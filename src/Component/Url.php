<?php

namespace Refinery29\Sitemap\Component;

use BadMethodCallException;
use DateTime;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

final class Url implements UrlInterface
{
    const CHANGE_FREQUENCY_ALWAYS = 'always';
    const CHANGE_FREQUENCY_HOURLY = 'hourly';
    const CHANGE_FREQUENCY_DAILY = 'daily';
    const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    const CHANGE_FREQUENCY_YEARLY = 'yearly';
    const CHANGE_FREQUENCY_NEVER = 'never';

    /**
     * Constant for maximum number of images.
     *
     * @link https://support.google.com/webmasters/answer/178636?hl=en
     */
    const IMAGE_MAX_COUNT = 1000;

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
     * @param string        $location
     * @param DateTime|null $lastModified
     * @param string|null   $changeFrequency
     * @param string|null   $priority
     */
    public function __construct($location, DateTime $lastModified = null, $changeFrequency = null, $priority = null)
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
        if (count($this->images) === self::IMAGE_MAX_COUNT) {
            throw new BadMethodCallException(sprintf(
                'Can not add more than %s images',
                self::IMAGE_MAX_COUNT
            ));
        }

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
