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
