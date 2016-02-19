<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

use DateTime;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
interface UrlInterface
{
    /**
     * Constants for change frequencies.
     */
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
     * @return string
     */
    public function getLocation();

    /**
     * @return DateTime|null
     */
    public function getLastModified();

    /**
     * @return string|null
     */
    public function getChangeFrequency();

    /**
     * @return string|null
     */
    public function getPriority();

    /**
     * @return Image\ImageInterface[]
     */
    public function getImages();

    /**
     * @return News\NewsInterface[]
     */
    public function getNews();

    /**
     * @return Video\VideoInterface[]
     */
    public function getVideos();
}
