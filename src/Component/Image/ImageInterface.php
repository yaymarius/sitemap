<?php

namespace Refinery29\Sitemap\Component\Image;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
interface ImageInterface
{
    /**
     * @return string
     */
    public function getLocation();

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getCaption();

    /**
     * @return string|null
     */
    public function getGeoLocation();

    /**
     * @return string|null
     */
    public function getLicence();
}
